<?php

namespace WriteDown\API\Interfaces;

use WriteDown\Emails\EmailInterface;
use WriteDown\Slugs\GenerateSlugInterface;

interface APIInterface
{
    /**
     * Work with posts.
     *
     * @param \WriteDown\Slugs\GenerateSlugInterface $generateSlug
     *
     * @return \WriteDown\API\Interfaces\EndpointInterface;
     */
    public function post(GenerateSlugInterface $generateSlug = null) : EndpointInterface;

    /**
     * Work with users.
     *
     * @param \WriteDown\Emails\EmailInterface $emails
     *
     * @return \WriteDown\API\Interfaces\EndpointInterface
     */
    public function user(EmailInterface $emails = null) : EndpointInterface;
}
