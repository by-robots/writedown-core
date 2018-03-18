<?php

namespace WriteDown\API;

/**
 * Responsible for building a consistent API response.
 */
class ResponseBuilder
{
    /**
     * Return on object.
     *
     * @param mixed   $data    An array in the case of multiple objects, or an
     *                         object when only one item is being returned (i.e.
     *                         a read request).
     * @param boolean $success
     *
     * @return array
     */
    public function build($data, $success = true)
    {
        return [
            'data'    => $data,
            'success' => $success,
        ];
    }
}
