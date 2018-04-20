<?php

namespace WriteDown\API\Endpoints;

use Doctrine\ORM\EntityManager;
use WriteDown\API\CRUD;
use WriteDown\API\Interfaces\PostEndpointInterface;
use WriteDown\API\ResponseBuilder;
use WriteDown\API\Transformers\PostTransformer;
use WriteDown\Slugs\GenerateSlugInterface;
use WriteDown\Validator\ValidatorInterface;

class Post extends CRUD implements PostEndpointInterface
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
    public function __construct(
        EntityManager $db,
        ResponseBuilder $response,
        ValidatorInterface $validator,
        GenerateSlugInterface $generateSlug
    ) {
        $this->db          = $db;
        $this->response    = $response;
        $this->validator   = $validator;
        $this->slug        = $generateSlug;

        // Set additional CRUD settings
        $this->entityRepo = 'WriteDown\Database\Entities\Post';
        $this->entity     = 'Post';

        // Set the transformer for this model
        $this->response->setTransformer(new PostTransformer); // TODO: Inject this
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes) : array
    {
        // If a slug has been manually set check that it's unique
        if (isset($attributes['slug']) and !$this->slug->isUnique($attributes['slug'])) {
            return $this->response->build([
                'slug' => ['The slug value is not unique.'],
            ], false);
        }

        // If no slug has been set generate it with the post's title
        if (
            (!isset($attributes['slug']) or empty($attributes['slug'])) and
            isset($attributes['title'])
        ) {
            $attributes['slug'] = $this->slug->uniqueSlug($attributes['title']);
        }

        // Let the parent finish off the validation and creation
        return parent::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update($entityID, array $attributes) : array
    {
        // First up, check the slug is unique.
        // A slug has been manually set so check it's unique
        if (isset($attributes['slug']) and !$this->slug->isUniqueExcept($attributes['slug'], $entityID)) {
            return $this->response->build([
                'slug' => ['The slug value is not unique.'],
            ], false);
        }

        return parent::update($entityID, $attributes);
    }

    /**
     * @inheritDoc
     */
    public function bySlug($slug) : array
    {
        $entity = $this->db->getRepository($this->entityRepo)->findOneBy(['slug' => $slug]);
        if (!$entity) {
            return $this->response->build(['Not found.'], false);
        }

        return $this->response->build($entity, true, $this->db->getRepository($this->entityRepo));
    }
}
