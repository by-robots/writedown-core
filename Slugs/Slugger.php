<?php

namespace Tests\Slugs;

use Tests\TestCase;
use WriteDown\Slugs\Slugger as Provider;

class Slugger extends TestCase
{
    public function testSingleWord()
    {
        $word    = $this->faker->word;
        $slugger = new Provider;
        $this->assertEquals($word, $slugger->slug($word));
    }

    public function testTwoWords()
    {
        $input    = 'two words';
        $expected = 'two-words';
        $slugger  = new Provider;

        $this->assertEquals($expected, $slugger->slug($input));
    }

    public function testHyphen()
    {
        $input   = 'two-words';
        $slugger = new Provider;
        $this->assertEquals($input, $slugger->slug($input));
    }

    public function testPunctuation()
    {
        $input    = 'word±#!@£$%^&*(){}[]_-+="\'|\:;?/>.<,~`';
        $expected = 'word';
        $slugger  = new Provider;

        $this->assertEquals($expected, $slugger->slug($input));
    }

    public function testLotsOfHyphens()
    {
        $input    = 'two-------words';
        $expected = 'two-words';
        $slugger  = new Provider;

        $this->assertEquals($expected, $slugger->slug($input));
    }

    public function testDigits()
    {
        $input   = '123word';
        $slugger = new Provider;
        $this->assertEquals($input, $slugger->slug($input));
    }

    public function testTrailingHyphen()
    {
        $input    = 'word-';
        $expected = 'word';
        $slugger  = new Provider;

        $this->assertEquals($expected, $slugger->slug($input));
    }

    public function testLeadingHyphen()
    {
        $input    = '-word';
        $expected = 'word';
        $slugger  = new Provider;

        $this->assertEquals($expected, $slugger->slug($input));
    }

    public function testCasing()
    {
        $input    = 'Word';
        $expected = 'word';
        $slugger  = new Provider;

        $this->assertEquals($expected, $slugger->slug($input));
    }
}
