<?php

namespace Tests\Markdown;

use Tests\TestCase;

class ToHtml extends TestCase
{
    /**
     * Markdown should be converted to HTML.
     */
    public function testBasic()
    {
        $sentence = $this->faker->sentence;
        $expected = '<p>' . $sentence . '</p>';

        $this->assertEquals($expected, $this->writedown->markdown()->markdownToHtml($sentence));
    }
}