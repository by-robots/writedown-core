<?php

namespace WriteDown\Database;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use WriteDown\Database\Interfaces\DriverInterface;

class DoctrineDriver implements DriverInterface
{
    /**
     * The database manager.
     *
     * \Doctrine\ORM\EntityManager
     */
    private $manager;

    /**
     * Get the database connection set-up.
     *
     * @param array   $config
     * @param boolean $devMode See Doctrine docs for details.
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(array $config, $devMode = false)
    {
        $setup         = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../../Entities'], $devMode);
        $this->manager = EntityManager::create($config, $setup);
    }

    /**
     * @inheritDoc
     */
    public function getManager() : EntityManagerInterface
    {
        return $this->manager;
    }
}
