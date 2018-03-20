<?php

namespace Tests\Misc;

use Tests\TestCase;
use WriteDown\Misc\Slugger as Provider;

class Slugger extends TestCase
{
    /**
     * The slugger interface.
     *
     * @var \WriteDown\Misc\Slugger
     */
    private $slugger;

    /**
     * Set up an instance of slugger to test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->slugger = new Provider;
    }

    public function testSingleWord()
    {
        $word = $this->faker->word;
        $this->assertEquals($word, $this->slugger->slug($word));
    }

    public function testTwoWords()
    {
        $input    = 'two words';
        $expected = 'two-words';

        $this->assertEquals($expected, $this->slugger->slug($input));
    }

    public function testHyphen()
    {
        $input = 'two-words';
        $this->assertEquals($input, $this->slugger->slug($input));
    }

    public function testPunctuation()
    {
        $input    = 'word±#!@£$%^&*(){}[]_-+="\'|\:;?/>.<,~`';
        $expected = 'word';

        $this->assertEquals($expected, $this->slugger->slug($input));
    }

    public function testLotsOfHyphens()
    {
        $input    = 'two-------words';
        $expected = 'two-words';

        $this->assertEquals($expected, $this->slugger->slug($input));
    }

    public function testDigits()
    {
        $input = '123word';
        $this->assertEquals($input, $this->slugger->slug($input));
    }

    public function testTrailingHyphen()
    {
        $input    = 'word-';
        $expected = 'word';

        $this->assertEquals($expected, $this->slugger->slug($input));
    }

    public function testLeadingHyphen()
    {
        $input    = '-word';
        $expected = 'word';

        $this->assertEquals($expected, $this->slugger->slug($input));
    }
}
