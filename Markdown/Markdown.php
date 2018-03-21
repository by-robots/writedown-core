<?php

namespace WriteDown\Markdown;

use League\CommonMark\CommonMarkConverter;
use League\HTMLToMarkdown\HtmlConverter;

class Markdown implements MarkdownInterface
{
    /**
     * Take HTML, make Markdown.
     *
     * @param string $html
     *
     * @return string
     */
    public function htmlToMarkdown($html)
    {
        $converter = new HtmlConverter();
        return $converter->convert($html);
    }

    /**
     * Take Markdown, make HTML.
     *
     * @param string $markdown
     *
     * @return string
     */
    public function markdownToHtml($markdown)
    {
        $converter = new CommonMarkConverter();
        return trim($converter->convertToHtml($markdown));
    }
}