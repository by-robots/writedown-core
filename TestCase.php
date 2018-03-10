<?php

namespace Tests;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class TestCase extends MockeryTestCase
{
    /**
     * The WriteDown object.
     *
     * @var WriteDown\WriteDown
     */
    protected $writedown;

    /**
     * Set-up for testing.
     *
     * @return void
     */
    public function setUp()
    {
        $this->writedown = require_once __DIR__ . '/../boot/start.php';
    }

    /**
     * Tidy-up after ourselves.
     *
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
    }
}
