<?php

namespace WriteDown\Database;

use WriteDown\Database\Interfaces\ConfigBuilderInterface;

class DoctrineConfigBuilder implements ConfigBuilderInterface
{
    /**
     * Generate a database config array based on the environment for Doctrine.
     *
     * @return array
     * @throws \Exception
     */
    public function generate()
    {
        switch (getenv('DB_DRIVER')) {
            case 'sqlite':
                $driver = 'pdo_sqlite';
                break;

            default:
                throw new \Exception('The provided database driver is not supported: ' .
                    /** @scrutinizer ignore-type */ getenv('DB_DRIVER'));
        }

        return [
            'driver' => $driver,
            'path'   => getenv('DB_DATABASE'),
        ];
    }
}
