<?php

namespace WriteDown\Database;

use WriteDown\Database\Interfaces\ConfigBuilderInterface;

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

        $path = explode('/', env('DB_DATABASE'));
        $file = array_pop($path);
        $path = realpath(__DIR__ . '/../../' . implode('/', $path));
        $path = $path . '/' . $file;

        return [
            'driver' => $driver,
            'path'   => $path,
        ];
    }
}
