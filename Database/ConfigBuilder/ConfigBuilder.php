<?php

namespace Tests\Database\ConfigBuilder;

use Tests\TestCase;
use WriteDown\Database\DoctrineConfigBuilder;

class ConfigBuilder extends TestCase
{
    /**
     * We'll be changing the DB_DRIVER setting and then throwing an exception
     * so we'll store the old driver setting here so it can be reset in the
     * tearDown function.
     *
     * @var string
     */
    private $oldDriver = null;

    /**
     * When provided with an invalid driver and exception should be thrown.
     */
    public function testHandlesBadDriver()
    {
        $configBuilder   = new DoctrineConfigBuilder;
        $this->oldDriver = env('DB_DRIVER');

        // We'll expect an exception to be thrown
        $this->expectException(\Exception::class);

        // Set the driver to be nonsense and try to generate the config
        putenv('DB_DRIVER=Zmx5aW5nIHByaW5jZXNzIGxlaWE=');
        $configBuilder->generate();
    }

    /**
     * Reset the DB_DRIVER value.
     *
     * @return void
     */
    public function tearDown()
    {
        if ($this->oldDriver) {
            putenv('DB_DRIVER=' . $this->oldDriver);
        }

        parent::tearDown();
    }
}
