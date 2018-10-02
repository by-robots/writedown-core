<?php

namespace ByRobots\WriteDown\Database;

use ByRobots\WriteDown\Database\Interfaces\ConfigBuilderInterface;

class DoctrineConfigBuilder implements ConfigBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function generate() : array
    {
        switch (env('DB_DRIVER')) {
            case 'mysql':
                return [
                    'dbname'   => getenv('DB_DATABASE'),
                    'driver'   => 'pdo_mysql',
                    'host'     => getenv('DB_HOST'),
                    'password' => getenv('DB_PASSWORD'),
                    'user'     => getenv('DB_USER'),
                ];
            case 'sqlite':
                return [
                    'driver' => 'pdo_sqlite',
                    'path'   => env('ROOT_PATH') . '/' . env('DB_DATABASE'),
                ];

            default:
                throw new \Exception('The provided database driver is not supported: ' .
                    /** @scrutinizer ignore-type */ env('DB_DRIVER'));
        }
    }
}
