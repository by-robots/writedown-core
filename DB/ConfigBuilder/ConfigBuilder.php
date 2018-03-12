<?php

namespace WriteDown\DB\ConfigBuilder;

interface ConfigBuilder
{
    /**
     * Generate a database config array based on the environment.
     *
     * @return array
     */
    public function generate();
}
