<?php

namespace ByRobots\WriteDown\Markdown;

interface MarkdownInterface
{
    /**
     * Take HTML, make Markdown.
     *
     * @param string $html
     *
     * @return string
     */
    public function htmlToMarkdown($html):string;

    /**
     * Take Markdown, make HTML.
     *
     * @param string $markdown
     *
     * @return string
     */
    public function markdownToHtml($markdown):string;
}
