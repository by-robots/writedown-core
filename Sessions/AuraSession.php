<?php

namespace WriteDown\Sessions;

use Aura\Session\SessionFactory;

/**
 * No need to include this class in code coverage for now,
 * Aura Sessions has it's own tests.
 *
 * @codeCoverageIgnore
 */
class AuraSession implements SessionInterface
{
    /**
     * @var \Aura\Session\Segment
     */
    private $segment;

    /**
     * Set-up.
     *
     * @return void
     */
    public function __construct()
    {
        $sessionFactory = new SessionFactory();
        $session        = $sessionFactory->newInstance($_COOKIE);
        $this->segment  = $session->getSegment('WriteDown\WriteDown');
    }

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
        $this->segment->get($key, $alt);
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
        $this->segment->set($key, $val);
    }

    /**
     * Clear all session data.
     *
     * @return void
     */
    public function clear()
    {
        $this->segment->clear();
    }

    /**
     * Sets a flash value for the next request.
     *
     * @param string $key
     * @param mixed  $val
     *
     * @return void
     */
    public function setFlash($key, $val)
    {
        $this->segment->setFlash($key, $val);
    }

    /**
     * Gets the flash value for a key in the current request.
     *
     * @param string $key
     * @param mixed  $alt
     *
     * @return mixed
     */
    public function getFlash($key, $alt = null)
    {
        $this->segment->getFlash($key, $alt);
    }

    /**
     * Clears any set flash data.
     *
     * @return void
     */
    public function clearFlash()
    {
        $this->segment->clearFlash();
    }

    /**
     * Retains all the current flash values for the next request; values that
     * already exist for the next request take precedence.
     *
     * @return null
     */
    public function keepFlash()
    {
        $this->segment->keepFlash();
    }
}
