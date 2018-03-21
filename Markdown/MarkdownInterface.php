<?php

namespace WriteDown\Markdown;

interface MarkdownInterface
{
    /**
     * Take HTML, make Markdown.
     *
     * @param string $html
     *
     * @return string
     */
    public function htmlToMarkdown($html);

    /**
     * Take Markdown, make HTML.
     *
     * @param string $markdown
     *
     * @return string
     */
    public function markdownToHtml($markdown);
}