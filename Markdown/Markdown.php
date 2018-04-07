<?php

namespace WriteDown\Markdown;

use League\CommonMark\CommonMarkConverter;
use League\HTMLToMarkdown\HtmlConverter;

class Markdown implements MarkdownInterface
{
    /**
     * @inheritDoc
     */
    public function htmlToMarkdown($html) : string
    {
        $converter = new HtmlConverter();
        return $converter->convert($html);
    }

    /**
     * @inheritDoc
     */
    public function markdownToHtml($markdown) : string
    {
        $converter = new CommonMarkConverter();
        return trim($converter->convertToHtml($markdown));
    }
}
