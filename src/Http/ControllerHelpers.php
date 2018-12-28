<?php

namespace ByRobots\WriteDown\Http;

/**
 * Some helpful shortcuts.
 */
trait ControllerHelpers
{
    /**
     * Get the currently logged in user.
     *
     * @return \ByRobots\WriteDown\Database\Entities\User|bool
     */
    public function loggedInAs()
    {
        return $this->auth->user($this->session->get('auth_token'));
    }
}
