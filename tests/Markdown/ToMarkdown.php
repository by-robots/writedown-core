<?php

namespace Tests\Markdown;

use Tests\TestCase;

class ToMarkdown extends TestCase
{
    /**
     * Markdown should be converted to HTML.
     */
    public function testBasic()
    {
        $sentence = $this->faker->sentence;

        $this->assertEquals($sentence, $this->writedown->markdown()->htmlToMarkdown('<p>' . $sentence . '</p>'));
    }
}