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
     * Generate test entities.
     *
     * @var Tests\CreatesResources
     */
    protected $resources;

    /**
     * Make WriteDown.
     *
     * @return WriteDown\WriteDown
     */
    protected function makeWritedown()
    {
        return require_once __DIR__ . '/../boot/start.php';
    }

    /**
     * Set-up for testing.
     *
     * @return void
     */
    public function setUp()
    {
        if (!$this->writedown) {
            $this->writedown = $this->makeWritedown();
        }

        $this->resources = new CreatesResources($this->writedown->database());
    }

    /**
     * Tidy-up after ourselves.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->writedown = null;
        Mockery::close();
    }
}
