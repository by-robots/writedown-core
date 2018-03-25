<?php

namespace WriteDown\API\Post;

use Doctrine\ORM\EntityManager;
use WriteDown\API\CRUD;
use WriteDown\API\EndpointInterface;
use WriteDown\API\ResponseBuilder;
use WriteDown\Entities\Post as Entity;
use WriteDown\Slugs\GenerateSlugInterface;
use WriteDown\Validator\ValidatorInterface;

class Post extends CRUD implements EndpointInterface
{
    /**
     * Checks slugs are unique.
     *
     * @var \WriteDown\Slugs\GenerateSlugInterface
     */
    private $slug;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager             $db
     * @param \WriteDown\API\ResponseBuilder          $response
     * @param \WriteDown\Validator\ValidatorInterface $validator
     * @param \WriteDown\Slugs\GenerateSlugInterface  $generateSlug
     *
     * @return void
     */
    public function __construct(EntityManager $db, ResponseBuilder $response, ValidatorInterface $validator, GenerateSlugInterface $generateSlug)
    {
        $this->db         = $db;
        $this->response   = $response;
        $this->validator  = $validator;
        $this->slug       = $generateSlug;

        // Set additional CRUD settings
        $this->entityRepo = 'WriteDown\Entities\Post';
        $this->entity     = 'Post';
    }

    /**
     * Create a new post. The CRUD::create() method has to be over-ridden in
     * order to work with slugs.
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
     * Update an entity.
     *
     * @param int   $entityID
     * @param array $attributes
     *
     * @return array
     */
    public function update($entityID, array $attributes)
    {
        // First up, check the slug is unique.
        // A slug has been manually set so check it's unique
        if (
            array_key_exists('slug', $attributes) and
            !$this->slug->isUniqueExcept($attributes['slug'], $entityID)
        ) {
            return $this->response->build([
                'slug' => 'The slug value is not unique.'
            ], false);
        }

        return parent::update($entityID, $attributes);
    }
}
