<?php

namespace WriteDown\Database\Interfaces;

interface ConfigBuilderInterface
{
    /**
     * Generate a database config array based on the environment.
     *
     * @return array
     * @throws \Exception
     */
    public function generate();
}
