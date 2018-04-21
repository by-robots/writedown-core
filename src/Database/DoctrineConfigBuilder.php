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
            case 'sqlite':
                $driver = 'pdo_sqlite';
                break;

            default:
                throw new \Exception('The provided database driver is not supported: ' .
                    /** @scrutinizer ignore-type */ env('DB_DRIVER'));
        }

        $path = env('ROOT_PATH') . '/' . env('DB_DATABASE');

        return [
            'driver' => $driver,
            'path'   => $path,
        ];
    }
}
