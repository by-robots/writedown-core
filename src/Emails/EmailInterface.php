<?php

namespace ByRobots\WriteDown\Emails;

interface EmailInterface
{
    /**
     * Check the email address is unique.
     *
     * @param string $email
     *
     * @return boolean
     */
    public function isUnique($email) : bool;

    /**
     * Check that the email is unique, unless it matches the given User ID.
     *
     * @param string  $email
     * @param integer $userID
     *
     * @return boolean
     */
    public function isUniqueExcept($email, $userID) : bool;
}
