<?php

namespace WriteDown\Database\Drivers;

interface DriverInterface
{
    /**
     * Return the manager.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function getManager();
}
