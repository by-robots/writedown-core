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
