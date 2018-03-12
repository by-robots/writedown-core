<?php

namespace WriteDown\DB\ConfigBuilder;

class Doctrine implements ConfigBuilder
{
    /**
     * Generate a database config array based on the environment for Doctrine.
     *
     * @return array
     */
    public function generate()
    {
        switch (getenv('DB_DRIVER')) {
            case 'sqlite':
                $driver = 'pdo_sqlite';
                break;
        }

        return [
            'driver' => $driver,
            'path'   => getenv('DB_DATABASE'),
        ];
    }
}
