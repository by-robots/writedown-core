<?php

namespace WriteDown\API\Post;

use Doctrine\ORM\EntityManager;
use WriteDown\API\ResponseBuilder;
use WriteDown\Entities\Post as Entity;

class Post
{
    /**
     * The EntityManager.
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
     * Set-up.
     *
     * @return void
     */
    public function __construct(EntityManager $db, ResponseBuilder $response)
    {
        $this->db       = $db;
        $this->response = $response;
    }

    /**
     * List all posts.
     *
     * @return array
     */
    public function index()
    {
        $posts = $this->db->getRepository('WriteDown\Entities\Post')->findAll();
        return $this->response->build($posts);
    }

    /**
     * Retrieve a single post.
     *
     * @param int $postID
     *
     * @return \WriteDown\Entities\Post
     */
    public function read($postID)
    {
        $post = $this->db->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $postID]);

        return $this->response->build($post, !$post ? false : true);
    }

    /**
     * Create a new post.
     *
     * @param array $attributes
     *
     * @return \WriteDown\Entities\Post
     */
    public function create(array $attributes)
    {
        // Create the post, loop through the attributes and populate the entity
        $post = new Entity;
        foreach ($attributes as $column => $value) {
            $post->$column = $value;
        }

        $this->db->persist($post);
        $this->db->flush();
        return $this->response->build($post);
    }
}
