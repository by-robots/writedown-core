<?php

namespace Tests\Stubs;

use WriteDown\Sessions\SessionInterface;

class SessionStub implements SessionInterface
{
    /**
     * The session data.
     *
     * @var array
     */
    private $session = [];

    /**
     * Returns the value of a key.
     *
     * @param string $key The key to retrieve.
     * @param mixed  $alt If $key is not set, return this.
     *
     * @return mixed
     */
    public function get($key, $alt = null)
    {
        return array_key_exists($key, $this->session) ? $this->session[$key] : $alt;
    }

    /**
     * Sets the value of a key in the segment.
     *
     * @param string $key The key to set.
     * @param mixed  $val The value to set it to.
     *
     * @return void
     */
    public function set($key, $val)
    {
        $this->session[$key] = $val;
    }

    /**
     * Clear all session data.
     *
     * @return void
     */
    public function clear()
    {
        $this->session = [];
    }

    /**
     * These methods are not implemented in this stub.
     */
    public function setFlash($key, $val) {}
    public function getFlash($key, $alt = null) {}
    public function clearFlash() {}
    public function keepFlash() {}
}
