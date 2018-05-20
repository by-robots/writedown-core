<?php

namespace ByRobots\WriteDown\API\Endpoints;

use Doctrine\ORM\EntityManager;
use ByRobots\WriteDown\API\CRUD;
use ByRobots\WriteDown\API\Interfaces\PostEndpointInterface;
use ByRobots\WriteDown\API\ResponseBuilder;
use ByRobots\WriteDown\API\Transformers\PostTransformer;
use ByRobots\WriteDown\Slugs\GenerateSlugInterface;
use ByRobots\WriteDown\Validator\ValidatorInterface;

class Post extends CRUD implements PostEndpointInterface
{
    /**
     * Checks slugs are unique.
     *
     * @var \ByRobots\WriteDown\Slugs\GenerateSlugInterface
     */
    private $slug;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager                      $db
     * @param \ByRobots\WriteDown\API\ResponseBuilder          $response
     * @param \ByRobots\WriteDown\Validator\ValidatorInterface $validator
     * @param \ByRobots\WriteDown\Slugs\GenerateSlugInterface  $generateSlug
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
        $this->entityRepo = 'ByRobots\WriteDown\Database\Entities\Post';
        $this->entity     = 'Post';

        // Set the transformer for this model
        $this->response->setTransformer(new PostTransformer); // TODO: Inject this
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes) : array
    {
        // If no slug has been set generate it with the post's title
        if (
            (!isset($attributes['slug']) or empty($attributes['slug'])) and
            isset($attributes['title'])
        ) {
            $attributes['slug'] = $this->slug->slug($attributes['title']);
        }

        // Let the parent finish off the validation and creation
        return parent::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update($entityID, array $attributes) : array
    {
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
