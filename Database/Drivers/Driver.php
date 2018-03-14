<?php

namespace WriteDown\Database\Drivers;

interface Driver
{
    /**
     * Return the manager.
     *
     * @return Doctrine\ORM\EntityManagerInterface
     */
    public function getManager();
}
