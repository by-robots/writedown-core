<?php

namespace Tests\Database\ConfigBuilder\Doctrine;

use Tests\TestCase;
use WriteDown\Database\ConfigBuilder\Doctrine;

class SQLite extends TestCase
{
    /**
     * Tests the config is generated from environment variables as expected.
     *
     * @return void
     */
    public function testGeneratesConfig()
    {
        $configBuilder = new Doctrine;
        $database      = 'road-to-nowhere';

        // Set-up the environment
        putenv('DB_DRIVER=sqlite');
        putenv('DB_DATABASE=' . $database);

        // Request the config
        $config = $configBuilder->generate();

        // Check it's what we expected
        $this->assertEquals(
            ['driver' => 'pdo_sqlite', 'path' => $database],
            $config
        );
    }
}
