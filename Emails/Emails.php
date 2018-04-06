<?php

namespace WriteDown\Emails;

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
    public function isUnique($email)
    {
        return !$this->db->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['email' => $email]) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function isUniqueExcept($email, $userID)
    {
        $result = $this->db->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['email' => $email]);

        if (!$result) {
            return true;
        }

        return $result->id == $userID ? true : false;
    }
}
