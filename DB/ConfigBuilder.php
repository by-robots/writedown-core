<?php

namespace WriteDown\DB;

class ConfigBuilder
{
    /**
     * Generate a database config array based on the environment.
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
