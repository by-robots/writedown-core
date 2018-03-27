<?php

namespace WriteDown\Database\Interfaces;

interface DriverInterface
{
    /**
     * Return the manager.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function getManager();
}
