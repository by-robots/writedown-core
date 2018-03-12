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
     * Set-up for testing.
     *
     * @return void
     */
    public function setUp()
    {
        // Start WriteDown
        $this->writedown = require_once __DIR__ . '/../boot/start.php';

        // Set-up testing tools
        $this->resources = new CreatesResources(
            $this->writedown->getContainer()->get('db')->getManager()
        );
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
