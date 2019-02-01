<?php

namespace Tests\Database\ConfigBuilder\Doctrine;

use Tests\TestCase;
use ByRobots\WriteDown\Database\DoctrineConfigBuilder;

class MySQL extends TestCase
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
        $newDatabase       = 'mysql_database';
        $this->oldDatabase = env('DB_DATABASE');
        $user              = 'number_six';
        $password          = 'gaius_baltar';
        $host              = 'baseship-12.cylons.org';

        // Set-up the environment
        putenv('DB_DATABASE=' . $newDatabase);
        putenv('DB_DRIVER=mysql');
        putenv('DB_HOST=' . $host);
        putenv('DB_PASSWORD=' . $password);
        putenv('DB_USER=' . $user);

        // Request the config
        $config = $configBuilder->generate();

        // Check the config is what we expected
        $this->assertEquals([
            'dbname'   => $newDatabase,
            'driver'   => 'pdo_mysql',
            'host'     => $host,
            'password' => $password,
            'user'     => $user,
        ], $config);
    }

    /**
     * Reset the environment values.
     *
     * @return void
     */
    public function tearDown(): void
    {
        if ($this->oldDatabase) {
            putenv('DB_DATABASE=' . $this->oldDatabase);
            putenv('DB_DRIVER=sqlite');
            putenv('DB_HOST=');
            putenv('DB_PASSWORD=');
            putenv('DB_USER=');
        }

        parent::tearDown();
    }
}
