<?php

namespace WriteDown\Database\ConfigBuilder;

class Doctrine implements ConfigBuilder
{
    /**
     * Generate a database config array based on the environment for Doctrine.
     *
     * @return array
     * @throws \UnknownDatabaseDriverException
     */
    public function generate()
    {
        switch (getenv('DB_DRIVER')) {
            case 'sqlite':
                $driver = 'pdo_sqlite';
                break;

            default:
                throw new \Exception('The provided database driver is not supported.');
        }

        return [
            'driver' => $driver,
            'path'   => getenv('DB_DATABASE'),
        ];
    }
}
