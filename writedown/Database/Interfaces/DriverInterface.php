<?php

namespace WriteDown\Database\Interfaces;

use Doctrine\ORM\EntityManagerInterface;

interface DriverInterface
{
    /**
     * Return the manager.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function getManager() : EntityManagerInterface;
}
