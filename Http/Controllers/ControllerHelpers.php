<?php

namespace WriteDown\Http\Controllers;

/**
 * Some helpful shortcuts.
 */
trait ControllerHelpers
{
    /**
     * Get the currently logged in user.
     *
     * @return \WriteDown\Database\Entities\User|bool
     */
    public function loggedInAs()
    {
        return $this->auth->user($this->sessions->get('auth_token'));
    }
}
