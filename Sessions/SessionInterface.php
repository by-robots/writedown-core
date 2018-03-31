<?php

namespace WriteDown\Sessions;

/**
 * Lightly modified version of
 * https://github.com/auraphp/Aura.Session/blob/2.x/src/SegmentInterface.php
 */
interface SessionInterface
{
    /**
     * Returns the value of a key.
     *
     * @param string $key The key to retrieve.
     * @param mixed  $alt If $key is not set, return this.
     *
     * @return mixed
     */
    public function get($key, $alt = null);

    /**
     * Sets the value of a key in the segment.
     *
     * @param string $key The key to set.
     * @param mixed  $val The value to set it to.
     *
     * @return void
     */
    public function set($key, $val);

    /**
     * Clear all session data.
     *
     * @return void
     */
    public function clear();

    /**
     * Sets a flash value for the next request.
     *
     * @param string $key
     * @param mixed  $val
     *
     * @return void
     */
    public function setFlash($key, $val);

    /**
     * Gets the flash value for a key in the current request.
     *
     * @param string $key
     * @param mixed  $alt
     *
     * @return mixed
     */
    public function getFlash($key, $alt = null);

    /**
     * Clears any set flash data.
     *
     * @return void
     */
    public function clearFlash();

    /**
     * Retains all the current flash values for the next request; values that
     * already exist for the next request take precedence.
     *
     * @return null
     */
    public function keepFlash();
}
