<?php

namespace Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
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
     * Generate test data.
     *
     * @var Faker\Factory
     */
    protected $faker;

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
     * Deletes the test database if ti exists.
     *
     * @return void
     */
    public function tearDownDatabase()
    {
        if (file_exists(__DIR__ . '/../' . getenv('DB_DATABASE'))) {
            unlink(__DIR__ . '/../' . getenv('DB_DATABASE'));
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
        copy(__DIR__ . '/../db/writedown-test-clean', __DIR__ . '/../' . getenv('DB_DATABASE'));
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

        $this->faker     = Factory::create();
        $this->resources = new CreatesResources($this->writedown->database(), $this->faker);
    }

    /**
     * Tidy-up after ourselves.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->tearDownDatabase();
        parent::tearDown();
    }
}
