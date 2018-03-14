<?php

namespace WriteDown\Database\Drivers;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Doctrine implements Driver
{
    /**
     * The database manager.
     *
     * Doctrine\ORM\EntityManager
     */
    private $manager;

    /**
     * Get the database connection set-up.
     *
     * @param array   $config
     * @param boolean $devMode See Doctrine docs for details.
     *
     * @return void
     */
    public function __construct(array $config, $devMode = false)
    {
        $setup         = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../../Entities'], $devMode);
        $this->manager = EntityManager::create($config, $setup);
    }

    /**
     * Return the manager.
     *
     * @return Doctrine\ORM\EntityManagerInterface
     */
    public function getManager()
    {
        return $this->manager;
    }
}
