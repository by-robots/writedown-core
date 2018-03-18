<?php

namespace WriteDown\API\Post;

use Doctrine\ORM\EntityManager;
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
     * Set-up.
     *
     * @return void
     */
    public function __construct(EntityManager $db)
    {
        $this->db = $db;
    }

    /**
     * List all posts.
     *
     * @return array
     */
    public function index()
    {
        $posts = $this->db->getRepository('WriteDown\Entities\Post')->findAll();
        return $posts;
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
        return $this->db->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $postID]);
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
        return $post;
    }
}
