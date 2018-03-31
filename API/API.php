<?php

namespace WriteDown\API;

use Doctrine\ORM\EntityManager;
use WriteDown\API\Endpoints\Post;
use WriteDown\API\Endpoints\User;
use WriteDown\API\Interfaces\APIInterface;
use WriteDown\Emails\EmailInterface;
use WriteDown\Emails\Emails;
use WriteDown\Slugs\GenerateSlug;
use WriteDown\Slugs\GenerateSlugInterface;
use WriteDown\Validator\ValidatorInterface;

class API implements APIInterface
{
    /**
     * The EntityManager object.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $db;

    /**
     * Builds API responses.
     *
     * @var \WriteDown\API\ResponseBuilder
     */
    private $response;

    /**
     * Validates data.
     *
     * @var \WriteDown\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager             $database
     * @param \WriteDown\API\ResponseBuilder          $response
     * @param \WriteDown\Validator\ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(EntityManager $database, ResponseBuilder $response, ValidatorInterface $validator)
    {
        $this->db        = $database;
        $this->response  = $response;
        $this->validator = $validator;
    }

    /**
     * Work with posts.
     *
     * @param \WriteDown\Slugs\GenerateSlugInterface $generateSlug (optional)
     *
     * @return \WriteDown\API\Endpoints\Post
     */
    public function post(GenerateSlugInterface $generateSlug = null)
    {
        if (!$generateSlug) {
            $generateSlug = new GenerateSlug($this->db);
        }

        return new Post($this->db, $this->response, $this->validator, $generateSlug);
    }

    /**
     * Work with users.
     *
     * @param \WriteDown\Emails\EmailInterface $emails
     *
     * @return \WriteDown\API\Endpoints\User
     */
    public function user(EmailInterface $emails = null)
    {
        if (!$emails) {
            $emails = new Emails($this->db);
        }

        return new User($this->db, $this->response, $this->validator, $emails);
    }
}
