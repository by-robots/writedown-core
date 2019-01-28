<?php

namespace ByRobots\WriteDown\Validator\Rules;

use ByRobots\Validation\AbstractRule;
use Doctrine\ORM\EntityManager;

class Unique extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected $name = 'unique_in_database';

    /**
     * @inheritDoc
     */
    protected $messages = ['en' => 'is not unique'];

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
    public function validate($field, array $input, array $params = null): bool
    {
        $column = !empty($params['column']) ? $params['column'] : $field;
        $result = $this->db
            ->getRepository($params['repository'])
            ->findOneBy([$column => $input[$field]]);

        // No match, all good
        if (!$result) {
            return true;
        }

        // There's a match - if an exclusion is specified check to see if it
        // matches what we've got
        if (!empty($params['except']) and $result->id == $params['except']) {
            return true;
        }

        return false;
    }
}
