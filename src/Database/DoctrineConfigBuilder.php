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
        $driver = env('DB_DRIVER');
        switch ($driver) {
            case 'mysql':
            case 'sqlite':
                return $this->$driver();

            default:
                throw new \Exception('The provided database driver is not supported: ' .
                    /** @scrutinizer ignore-type */ env('DB_DRIVER'));
        }
    }

    /**
     * Build the SQLite connection.
     *
     * @return array
     */
    private function sqlite() : array
    {
        return [
            'driver' => 'pdo_sqlite',
            'path'   => env('ROOT_PATH') . '/' . env('DB_DATABASE'),
        ];
    }

    /**
     * Build the MySQL connection.
     *
     * @return array
     */
    private function mysql() : array
    {
        return [
            'dbname'   => getenv('DB_DATABASE'),
            'driver'   => 'pdo_mysql',
            'host'     => getenv('DB_HOST'),
            'password' => getenv('DB_PASSWORD'),
            'user'     => getenv('DB_USER'),
        ];
    }
}
