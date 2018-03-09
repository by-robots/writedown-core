<?php

namespace Tests;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class TestCase extends MockeryTestCase
{
    /**
     * Set-up for testing.
     *
     * @return void
     */
    public function setUp()
    {
        $writedown = require_once __DIR__ . '/../boot/start.php';
        return $writedown;
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
