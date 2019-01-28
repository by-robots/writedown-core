<?php

namespace ByRobots\WriteDown\Emails;

use Doctrine\ORM\EntityManager;

class Emails implements EmailInterface
{
    /**
     * The EntityManager object.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $db;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager $database
     *
     * @return void
     */
    public function __construct(EntityManager $database)
    {
        $this->db = $database;
    }

    /**
     * @inheritDoc
     */
    public function isUnique($email) : bool
    {
        return !$this->db
            ->getRepository('ByRobots\WriteDown\Database\Entities\User')
            ->findOneBy(['email' => $email]) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function isUniqueExcept($email, $userID) : bool
    {
        $result = $this->db
            ->getRepository('ByRobots\WriteDown\Database\Entities\User')
            ->findOneBy(['email' => $email]);

        if (!$result) {
            return true;
        }

        return $result->id == $userID ? true : false;
    }
}
