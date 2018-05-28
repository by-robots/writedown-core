<?php

namespace ByRobots\WriteDown\API\Interfaces;

use ByRobots\WriteDown\Emails\EmailInterface;
use ByRobots\WriteDown\Slugs\Slugger;

interface APIInterface
{
    /**
     * Work with posts.
     *
     * @param \ByRobots\WriteDown\Slugs\Slugger $slugger
     *
     * @return \ByRobots\WriteDown\API\Interfaces\PostEndpointInterface
     */
    public function post(Slugger $slugger = null) : PostEndpointInterface;

    /**
     * Work with users.
     *
     * @param \ByRobots\WriteDown\Emails\EmailInterface $emails
     *
     * @return \ByRobots\WriteDown\API\Interfaces\EndpointCRUInterface
     */
    public function user(EmailInterface $emails = null) : EndpointCRUInterface;

    /**
     * Work with tags.
     *
     * @return \ByRobots\WriteDown\API\Interfaces\EndpointCRUInterface
     */
    public function tag() : EndpointCRUInterface;

    /**
     * Work with the post_tag table. Allows posts to be tagged.
     *
     * @return \ByRobots\WriteDown\API\Interfaces\EndpointCRUInterface
     */
    public function postTag() : EndpointCRUInterface;
}
