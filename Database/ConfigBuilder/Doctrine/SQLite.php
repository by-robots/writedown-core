<?php

namespace Tests\Database\ConfigBuilder\Doctrine;

use Tests\TestCase;
use WriteDown\Database\ConfigBuilder\Doctrine;

class SQLite extends TestCase
{
    /**
     * Tests the config is generated from environment variables as expected.
     */
    public function testGeneratesConfig()
    {
        $configBuilder = new Doctrine;
        $newDatabase   = 'road-to-nowhere';
        $oldDatabase   = getenv('DB_DATABASE');

        // Set-up the environment
        // NOTE: In testing DB_DRIVER is already set so there's no need to
        //       manually specify it here.
        putenv('DB_DATABASE=' . $newDatabase);

        // Request the config
        $config = $configBuilder->generate();

        // Reset the config
        putenv('DB_DATABASE=' . $oldDatabase);

        // Check the config is what we expected
        $this->assertEquals(['driver' => 'pdo_sqlite', 'path' => $newDatabase], $config);
    }
}
