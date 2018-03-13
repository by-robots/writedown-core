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
    protected $writedown = null;

    /**
     * Generate test entities.
     *
     * @var Tests\CreatesResources
     */
    protected $resources = null;

    /**
     * Make WriteDown.
     *
     * @return WriteDown\WriteDown
     */
    protected function makeWritedown()
    {
        $this->writedown = require __DIR__ . '/../boot/start.php';
    }

    /**
     * Set-up for testing.
     *
     * @return void
     */
    public function setUp()
    {
        $this->makeWritedown();
        $this->resources = new CreatesResources($this->writedown->database());
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
