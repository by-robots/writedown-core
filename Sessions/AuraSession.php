<?php

namespace WriteDown\Sessions;

use Aura\Session\SessionFactory;

/**
 * No need to include this class in code coverage for now, Aura Sessions has
 * it's own tests. Plus, we can't really write to sessions in PHPUnit so a
 * stub we'll be used where needed.
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
     * @inheritDoc
     */
    public function get($key, $alt = null)
    {
        return $this->segment->get($key, $alt);
    }

    /**
     * @inheritDoc
     */
    public function set($key, $val)
    {
        $this->segment->set($key, $val);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->segment->clear();
    }

    /**
     * @inheritDoc
     */
    public function setFlash($key, $val)
    {
        $this->segment->setFlash($key, $val);
    }

    /**
     * @inheritDoc
     */
    public function getFlash($key, $alt = null)
    {
        $this->segment->getFlash($key, $alt);
    }

    /**
     * @inheritDoc
     */
    public function clearFlash()
    {
        $this->segment->clearFlash();
    }

    /**
     * @inheritDoc
     */
    public function keepFlash()
    {
        $this->segment->keepFlash();
    }
}
