<?php

namespace WriteDown\DB\Drivers;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Doctrine
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
     * @return Doctrine\ORM\EntityManager
     */
    public function __construct(array $config, $devMode = false)
    {
        $setup         = Setup::createAnnotationMetadataConfiguration(__DIR__ . '/../', $isDevMode);
        $this->manager = EntityManager::create($setup, $config);

        return $this->getManager();
    }

    /**
     * Return the manager.
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function &getManager()
    {
        return $this->manager;
    }
}
