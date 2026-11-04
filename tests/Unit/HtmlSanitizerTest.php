<?php

use App\Support\HtmlSanitizer;

/*
|--------------------------------------------------------------------------
| Milestone 0 — HtmlSanitizer
|--------------------------------------------------------------------------
| Article body HTML is rendered raw in Blade, so tenant/AI-authored markup
| must be stripped of anything executable while normal article content
| survives untouched.
*/

test('script tags are removed with their contents', function () {
    $out = HtmlSanitizer::sanitize('<p>Hello</p><script>alert("xss")</script>');

    expect($out)->toContain('<p>Hello</p>')
        ->not->toContain('<script')
        ->not->toContain('alert');
});

test('event handler attributes are removed from images', function () {
    $out = HtmlSanitizer::sanitize('<img src="https://cdn.example.com/a.webp" onerror="alert(1)" alt="A">');

    expect($out)->toContain('<img')
        ->toContain('https://cdn.example.com/a.webp')
        ->not->toContain('onerror')
        ->not->toContain('alert');
});

test('javascript: hrefs are neutralized', function () {
    $out = HtmlSanitizer::sanitize('<a href="javascript:alert(1)">click</a>');

    expect($out)->toContain('click')
        ->not->toContain('javascript:');
});

test('normal article markup survives', function () {
    $html = '<h2>Heading</h2><p>Text with <strong>bold</strong> and '
        . '<a href="https://example.com/post">a link</a>.</p>'
        . '<ul><li>One</li><li>Two</li></ul>'
        . '<img src="/media/abc123" alt="Cover">'
        . '<table><thead><tr><th>A</th></tr></thead><tbody><tr><td>1</td></tr></tbody></table>'
        . '<blockquote><p>Quote</p></blockquote>';

    $out = HtmlSanitizer::sanitize($html);

    expect($out)->toContain('<h2>Heading</h2>')
        ->toContain('<strong>bold</strong>')
        ->toContain('href="https://example.com/post"')
        ->toContain('rel="noopener nofollow"')
        ->toContain('<li>One</li>')
        ->toContain('src="/media/abc123"')
        ->toContain('<td>1</td>')
        ->toContain('<blockquote>');
});

test('youtube embed iframes are kept, other iframes are dropped', function () {
    $kept = HtmlSanitizer::sanitize('<iframe src="https://www.youtube.com/embed/abc123" width="560" height="315"></iframe>');
    $dropped = HtmlSanitizer::sanitize('<iframe src="https://evil.example.com/embed/1"></iframe><p>After</p>');

    expect($kept)->toContain('<iframe')
        ->toContain('youtube.com/embed/abc123')
        ->and($dropped)->not->toContain('<iframe')
        ->not->toContain('evil.example.com')
        ->toContain('<p>After</p>');
});

test('form elements and style attributes are stripped', function () {
    $out = HtmlSanitizer::sanitize('<form action="https://evil.example.com"><input type="text"></form><p style="color:red">Styled</p>');

    expect($out)->not->toContain('<form')
        ->not->toContain('<input')
        ->not->toContain('style=')
        ->toContain('<p>Styled</p>');
});
