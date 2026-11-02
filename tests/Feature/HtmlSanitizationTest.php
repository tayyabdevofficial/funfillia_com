<?php

test('clean_blog_html strips dangerous xss payloads', function () {
    $maliciousHtml = '<p>Normal text</p><script>alert("xss")</script><img src="x" onerror="alert(1)"><a href="javascript:alert(2)">click me</a>';
    $sanitized = clean_blog_html($maliciousHtml);

    expect($sanitized)->not->toContain('<script>');
    expect($sanitized)->not->toContain('onerror');
    expect($sanitized)->not->toContain('javascript:');
    expect($sanitized)->toContain('Normal text');
});

test('clean_blog_html preserves safe formatting elements', function () {
    $safeHtml = '<h2>Heading</h2><p>Paragraph with <strong>bold</strong> and <em>italic</em> text.</p><a href="https://example.com">Link</a>';
    $sanitized = clean_blog_html($safeHtml);

    expect($sanitized)->toContain('<h2>Heading</h2>');
    expect($sanitized)->toContain('<strong>bold</strong>');
    expect($sanitized)->toContain('<em>italic</em>');
    expect($sanitized)->toContain('href="https://example.com"');
});

