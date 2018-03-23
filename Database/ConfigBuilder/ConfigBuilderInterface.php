<?php

namespace WriteDown\Database\ConfigBuilder;

interface ConfigBuilderInterface
{
    /**
     * Generate a database config array based on the environment.
     *
     * @return array
     */
    public function generate();
}
