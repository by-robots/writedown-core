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
     * Check the email address is unique.
     *
     * @param string $email
     *
     * @return boolean
     */
    public function isUnique($email)
    {
        return !$this->db->getRepository('WriteDown\Entities\User')
            ->findOneBy(['email' => $email]) ? true : false;
    }

    /**
     * Check that the email is unique, unless it matches the given User ID.
     *
     * @param string  $email
     * @param integer $userID
     *
     * @return boolean
     */
    public function isUniqueExcept($email, $userID)
    {
        $result = $this->db->getRepository('WriteDown\Entities\User')
            ->findOneBy(['email' => $email]);

        if (!$result) {
            return true;
        }

        return $result->id == $userID ? true : false;
    }
}
