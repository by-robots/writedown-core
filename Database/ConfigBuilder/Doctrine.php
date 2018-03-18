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
                $driverVal = is_string(getenv('DB_DRIVER')) ? getenv('DB_DRIVER') : 'Non-string value';
                throw new \Exception('The provided database driver is not supported: ' . $driverVal);
        }

        return [
            'driver' => $driver,
            'path'   => getenv('DB_DATABASE'),
        ];
    }
}
