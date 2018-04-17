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
     * @inheritDoc
     */
    public function get($key, $alt = null)
    {
        return array_key_exists($key, $this->session) ? $this->session[$key] : $alt;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $val)
    {
        $this->session[$key] = $val;
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->session = [];
    }

    /**
     * @inheritDoc
     */
    public function destroy()
    {
        $this->clear();
    }

    /**
     * These methods are not implemented in this stub.
     */
    public function setFlash($key, $val) {}
    public function getFlash($key, $alt = null) {}
    public function clearFlash() {}
    public function keepFlash() {}
    public function csrf() {}
}
