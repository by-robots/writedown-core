<?php

namespace WriteDown\DB\Drivers;

use Illuminate\Database\Capsule\Manager;

class Eloquent
{
    /**
     * The database manager.
     *
     * Illuminate\Database\Capsule\Manager
     */
    private $manager;

    /**
     * Get the database connection set-up.
     *
     * @param array $config
     *
     * @return Illuminate\Database\Capsule\Manager
     */
    public function __construct(array $config)
    {
        $this->manager = new Manager;
        $this->manager->addConnection($config);

        $this->manager->bootEloquent();
    }
}
