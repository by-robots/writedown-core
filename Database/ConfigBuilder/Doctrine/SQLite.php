<?php

namespace Tests\Database\ConfigBuilder\Doctrine;

use Tests\TestCase;
use WriteDown\Database\DoctrineConfigBuilder;

class SQLite extends TestCase
{
    /**
     * We'll be changing the DB_DATABASE so we'll store the old driver setting
     * here so it can be reset in the tearDown function.
     *
     * @var string
     */
    private $oldDatabase = null;

    /**
     * Tests the config is generated from environment variables as expected.
     */
    public function testGeneratesConfig()
    {
        $configBuilder     = new DoctrineConfigBuilder;
        $newDatabase       = 'db/road-to-nowhere';
        $this->oldDatabase = getenv('DB_DATABASE');

        // Set-up the environment
        putenv('DB_DATABASE=' . $newDatabase);

        // Request the config
        $config = $configBuilder->generate();

        // Check the config is what we expected
        $this->assertEquals(['driver' => 'pdo_sqlite', 'path' => $newDatabase], $config);
    }

    /**
     * Reset the DB_DATABASE value.
     *
     * @return void
     */
    public function tearDown()
    {
        if ($this->oldDatabase) {
            putenv('DB_DATABASE=' . $this->oldDatabase);
        }

        parent::tearDown();
    }
}
