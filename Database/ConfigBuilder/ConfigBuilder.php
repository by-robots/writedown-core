<?php

namespace Tests\Database\ConfigBuilder;

use Tests\TestCase;
use WriteDown\Database\ConfigBuilder\Doctrine;

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

    public function testHandlesBadDriver()
    {
        $configBuilder   = new Doctrine;
        $this->oldDriver = getenv('DB_DRIVER');

        // We'll expect an exception to be thrown
        $this->expectException(\Exception::class);

        // Set the driver to be nonsense and try to generate the config
        putenv('DB_DRIVER=Zmx5aW5nIHByaW5jZXNzIGxlaWE=');
        $config = $configBuilder->generate();
    }

    /**
     * Reset the DB_DRIVER value.
     *
     * @return void
     */
    public function tearDown()
    {
        if ($oldDriver) {
            putenv('DB_DRIVER=' . $this->oldDriver);
        }
    }
}
