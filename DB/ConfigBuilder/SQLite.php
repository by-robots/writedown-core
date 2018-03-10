<?php

namespace Tests\DB\ConfigBuilder;

use Tests\TestCase;
use WriteDown\DB\ConfigBuilder;

class SQLite extends TestCase
{
    /**
     * The ConfigBuilder object.
     *
     * @var WriteDown\DB\ConfigBuilder
     */
    private $configBuilder;

    /**
     * Set-up.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->configBuilder = new ConfigBuilder;
    }

    /**
     * Tests the config is generated from environment variables as expected.
     *
     * @return void
     */
    public function testGeneratesConfig()
    {
        $driver   = 'sqlite';
        $database = 'road-to-nowhere';

        // Set-up the environment
        putenv('DB_DRIVER=' . $driver);
        putenv('DB_DATABASE=' . $database);

        // Request the config
        $config = $this->configBuilder->generate();

        // Check it's what we expected
        $this->assertEquals(
            ['driver' => $driver, 'database' => $database],
            $config
        );
    }
}
