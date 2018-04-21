<?php
if (!function_exists('env')) {
    /**
     * Load an environment variable. If it doesn't exists return $default.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    function env($key, $default = null) {
        if (getenv($key) === false) {
            return $default;
        }

        return getenv($key);
    }
}
