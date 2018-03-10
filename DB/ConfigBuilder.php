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
        return [
            'database' => getenv('DB_DATABASE'),
            'driver'   => getenv('DB_DRIVER'),
        ];
    }
}
