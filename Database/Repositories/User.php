<?php

namespace WriteDown\Database\Repositories;

use Doctrine\ORM\EntityRepository;

class User extends EntityRepository implements RepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all(array $filters = [])
    {
        return $this->findAll();
    }
}
