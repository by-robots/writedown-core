<?php

namespace Tests;

use Faker\Factory;
use League\Container\Container;
use PHPUnit\Framework\TestCase as BaseTestCase;
use ByRobots\WriteDown;

abstract class TestCase extends BaseTestCase
{
    /**
     * The ByRobots\WriteDown object.
     *
     * @var \ByRobots\WriteDown\WriteDown
     */
    protected $writedown;

    /**
     * Generate test entities.
     *
     * @var \Tests\CreatesResources
     */
    protected $resources;

    /**
     * Generate test data.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Make ByRobots\WriteDown.
     *
     * @return void
     */
    protected function makeWritedown()
    {
        // Start ByRobots\WriteDown
        $this->writedown = new WriteDown\WriteDown(new Container);
    }

    /**
     * Deletes the test database if it exists.
     *
     * @return void
     */
    public function tearDownDatabase()
    {
        if (file_exists(__DIR__ . '/../' . env('DB_DATABASE'))) {
            unlink(__DIR__ . '/../' . env('DB_DATABASE'));
        }
    }

    /**
     * Sets up the test database.
     *
     * @return void
     */
    public function setUpDatabase()
    {
        $this->tearDownDatabase();
        copy(
            __DIR__ . '/../db/writedown-test-clean',
            __DIR__ . '/../' . env('DB_DATABASE')
        );
    }

    /**
     * Set-up for testing.
     *
     * @return void
     */
    public function setUp()
    {
        $this->makeWritedown();
        $this->setUpDatabase();

        putenv('ROOT_PATH=' . realpath(__DIR__ . '/..'));

        $this->faker     = Factory::create();
        $this->resources = new CreatesResources($this->writedown->getService('entityManager'), $this->faker);
    }

    /**
     * Tidy-up after ourselves.
     *
     * @return void
     */
    public function tearDown()
    {
        \Mockery::close();
        $this->tearDownDatabase();
        parent::tearDown();
    }
}
