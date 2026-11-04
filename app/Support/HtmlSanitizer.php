<?php

namespace App\Support;

/**
 * Milestone 0 — conservative allowlist HTML sanitizer for article body
 * content (tenant- and AI-authored HTML that Blade renders raw).
 *
 * No external dependency: built on DOMDocument. Anything not explicitly
 * allowed is removed (dangerous elements with their contents) or
 * unwrapped (unknown formatting elements keep their text/children).
 */
class HtmlSanitizer
{
    /** Tags allowed in article content. */
    private const ALLOWED_TAGS = [
        'p', 'br', 'hr',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'strong', 'b', 'em', 'i', 'u', 'sub', 'sup',
        'a', 'img',
        'ul', 'ol', 'li',
        'blockquote', 'code', 'pre',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td',
        'figure', 'figcaption',
        'span', 'div',
        'iframe',
    ];

    /** Tags removed together with their contents. */
    private const REMOVE_WITH_CONTENTS = [
        'script', 'style', 'form', 'input', 'button', 'textarea',
        'select', 'option', 'link', 'meta', 'title', 'noscript',
        'object', 'embed', 'svg', 'math', 'template',
    ];

    /** Per-tag attribute allowlist (event handlers and style are never allowed). */
    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target'],
        'img' => ['src', 'alt', 'title', 'width', 'height', 'loading'],
        'th' => ['colspan', 'rowspan'],
        'td' => ['colspan', 'rowspan'],
        'iframe' => ['src', 'width', 'height', 'title', 'allow', 'allowfullscreen', 'frameborder'],
        'ol' => ['start'],
    ];

    /** Tags that may also carry a class attribute. */
    private const CLASSABLE_TAGS = [
        'p', 'span', 'div', 'table', 'figure', 'figcaption', 'blockquote', 'pre', 'code', 'img',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li',
    ];

    public static function sanitize(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        $previous = libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div id="__sanitizer_root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $dom->getElementsByTagName('div')->item(0);
        if (!$root) {
            return '';
        }

        self::processChildren($root);

        $out = '';
        foreach (iterator_to_array($root->childNodes) as $child) {
            $out .= $dom->saveHTML($child);
        }

        return trim($out);
    }

    private static function processChildren(\DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if ($node instanceof \DOMComment) {
                $parent->removeChild($node);
                continue;
            }

            if (!$node instanceof \DOMElement) {
                continue; // text nodes are safe
            }

            $tag = strtolower($node->tagName);

            if (in_array($tag, self::REMOVE_WITH_CONTENTS, true)) {
                $parent->removeChild($node);
                continue;
            }

            if (!in_array($tag, self::ALLOWED_TAGS, true)) {
                // Unwrap: sanitize children, then replace the element with them.
                self::processChildren($node);
                while ($node->firstChild) {
                    $parent->insertBefore($node->firstChild, $node);
                }
                $parent->removeChild($node);
                continue;
            }

            if ($tag === 'iframe' && !self::isAllowedEmbed((string) $node->getAttribute('src'))) {
                $parent->removeChild($node);
                continue;
            }

            self::cleanAttributes($node, $tag);
            self::processChildren($node);
        }
    }

    private static function cleanAttributes(\DOMElement $node, string $tag): void
    {
        $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];
        if (in_array($tag, self::CLASSABLE_TAGS, true)) {
            $allowed[] = 'class';
        }

        foreach (iterator_to_array($node->attributes ?? []) as $attribute) {
            $name = strtolower($attribute->name);
            if (!in_array($name, $allowed, true)) {
                $node->removeAttribute($attribute->name);
            }
        }

        if ($tag === 'a') {
            $href = trim((string) $node->getAttribute('href'));
            if ($href !== '' && !self::isSafeUrl($href, allowRelative: true, allowMailto: true)) {
                $node->removeAttribute('href');
            } else {
                $node->setAttribute('rel', 'noopener nofollow');
                if ($node->getAttribute('target') !== '_blank') {
                    $node->removeAttribute('target');
                }
            }
        }

        if ($tag === 'img') {
            $src = trim((string) $node->getAttribute('src'));
            if ($src === '' || !self::isSafeUrl($src, allowRelative: true, allowMailto: false)) {
                // Mark for removal by clearing src; handled by dropping the
                // element entirely (an <img> without a safe src is useless).
                $node->setAttribute('src', '');
                $node->parentNode?->removeChild($node);
            }
        }
    }

    private static function isSafeUrl(string $url, bool $allowRelative, bool $allowMailto): bool
    {
        if ($allowRelative && (str_starts_with($url, '/') || str_starts_with($url, '#'))) {
            return !str_starts_with($url, '//');
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return $scheme === 'http'
            || $scheme === 'https'
            || ($allowMailto && $scheme === 'mailto');
    }

    private static function isAllowedEmbed(string $src): bool
    {
        if ($src === '') {
            return false;
        }

        $host = strtolower((string) parse_url($src, PHP_URL_HOST));
        $path = (string) parse_url($src, PHP_URL_PATH);
        $scheme = strtolower((string) parse_url($src, PHP_URL_SCHEME));

        if ($scheme !== 'https') {
            return false;
        }

        return ($host === 'www.youtube.com' || $host === 'youtube.com' || $host === 'www.youtube-nocookie.com')
            && str_starts_with($path, '/embed/')
            || $host === 'player.vimeo.com' && str_starts_with($path, '/video/');
    }
}
