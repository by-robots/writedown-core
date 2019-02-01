<?php

namespace ByRobots\WriteDown\Validator\Rules;

use ByRobots\Validation\AbstractRule;
use Doctrine\ORM\EntityManager;

class Exists extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected $name = 'exists_in_database';

    /**
     * @inheritDoc
     */
    protected $messages = ['en' => 'does not exist in %s'];

    /**
     * The EntityManager object.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $db;

    /**
     * Set-up the rule.
     *
     * @param \Doctrine\ORM\EntityManager $database
     */
    public function __construct(EntityManager $database)
    {
        $this->db = $database;
    }

    /**
     * @inheritDoc
     */
    public function validate($field, array $input, array $params = null):bool
    {
        $column = !empty($params['column']) ? $params['column'] : 'id';
        $result = $this->db
            ->getRepository($params['repository'])
            ->findOneBy([$column => $input[$field]]);

        return $result ? true : false;
    }
}
