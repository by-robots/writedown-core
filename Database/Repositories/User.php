<?php

namespace WriteDown\Database\Repositories;

use WriteDown\Database\Interfaces\RepositoryInterface;

class User extends BaseRepository implements RepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all(array $filters = [])
    {
        return $this->findAll();
    }
}
