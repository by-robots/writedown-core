<?php

namespace WriteDown\API\Post;

use Doctrine\ORM\EntityManager;
use WriteDown\API\EndpointInterface;
use WriteDown\API\ResponseBuilder;
use WriteDown\Entities\Post as Entity;
use WriteDown\Slugs\GenerateSlugInterface;
use WriteDown\Validator\Validator;

class Post implements EndpointInterface
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
     * Validates data.
     *
     * @var \WriteDown\Validator\Validator
     */
    private $validator;

    /**
     * Checks slugs are unique.
     *
     * @var \WriteDown\Slugs\GenerateSlugInterface
     */
    private $slug;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager            $db
     * @param \WriteDown\API\ResponseBuilder         $response
     * @param \WriteDown\Validator\Validator         $validator
     * @param \WriteDown\Slugs\GenerateSlugInterface $generateSlug
     *
     * @return void
     */
    public function __construct(EntityManager $db, ResponseBuilder $response, Validator $validator, GenerateSlugInterface $generateSlug)
    {
        $this->db         = $db;
        $this->response   = $response;
        $this->validator  = $validator;
        $this->slug       = $generateSlug;
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
     * @return array
     */
    public function read($postID)
    {
        $post = $this->db->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $postID]);

        if (!$post) {
            return $this->response->build(['Not found.'], false);
        }

        return $this->response->build($post);
    }

    /**
     * Create a new post.
     *
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes)
    {
        // Create the post, loop through the attributes and populate the entity
        $post = new Entity;
        foreach ($attributes as $column => $value) {
            if (in_array($column, $post->fillable)) {
                $post->$column = $value;
            }
        }

        // Ensure a slug has been generated
        if (is_null($post->slug)) {
            $post->slug = $this->slug->uniqueSlug($post->title);
        } else {
            // A slug has been manually set so check it's unique
            if (!$this->slug->isUnique($post->slug)) {
                return $this->response->build([
                    'slug' => 'The slug value is not unique.'
                ], false);
            }
        }

        // Validate it
        if (!$this->validator->validate($post->rules, $post->validationArray())) {
            return $this->response->build($this->validator->errors(), false);
        }

        // Save it
        $this->db->persist($post);
        $this->db->flush();
        return $this->response->build($post);
    }

    /**
     * Update a post.
     *
     * @param int   $postID
     * @param array $attributes
     *
     * @return array
     */
    public function update($postID, array $attributes)
    {
        $post = $this->db->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $postID]);

        if (!$post) {
            return $this->response->build(['Not found.'], false);
        }

        // Populate entity attributes
        foreach ($attributes as $column => $value) {
            if (in_array($column, $post->fillable)) {
                $post->$column = $value;
            }
        }

        // Commit to the database and continue
        $this->db->flush();
        return $this->response->build($post);
    }

    /**
     * Delete a post.
     *
     * @param int $postID
     *
     * @return array
     */
    public function delete($postID)
    {
        $post = $this->db->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $postID]);

        if (!$post) {
            return $this->response->build(['Not found.'], false);
        }

        $this->db->remove($post);
        $this->db->flush();
        return $this->response->build([]);
    }
}
