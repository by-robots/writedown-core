<?php

namespace ByRobots\WriteDown\API\Interfaces;

use ByRobots\WriteDown\Emails\EmailInterface;
use ByRobots\WriteDown\Slugs\GenerateSlugInterface;

interface APIInterface
{
    /**
     * Work with posts.
     *
     * @param \ByRobots\WriteDown\Slugs\GenerateSlugInterface $generateSlug
     *
     * @return \ByRobots\WriteDown\API\Interfaces\PostEndpointInterface
     */
    public function post(GenerateSlugInterface $generateSlug = null) : PostEndpointInterface;

    /**
     * Work with users.
     *
     * @param \ByRobots\WriteDown\Emails\EmailInterface $emails
     *
     * @return \ByRobots\WriteDown\API\Interfaces\EndpointInterface
     */
    public function user(EmailInterface $emails = null) : EndpointInterface;
}
