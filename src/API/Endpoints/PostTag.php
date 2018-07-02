<?php

namespace ByRobots\WriteDown\API\Endpoints;

use ByRobots\WriteDown\API\CRU;
use ByRobots\WriteDown\API\Interfaces\PostTagEndpointInterface;
use ByRobots\WriteDown\API\ResponseBuilder;
use ByRobots\WriteDown\API\Transformers\PostTagTransformer;
use ByRobots\WriteDown\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManager;

class PostTag extends CRU implements PostTagEndpointInterface
{

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager                      $db
     * @param \ByRobots\WriteDown\API\ResponseBuilder          $response
     * @param \ByRobots\WriteDown\Validator\ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(
        EntityManager $db,
        ResponseBuilder $response,
        ValidatorInterface $validator
    ) {
        $this->db          = $db;
        $this->response    = $response;
        $this->validator   = $validator;

        // Set additional CRUD settings
        $this->entityRepo = 'ByRobots\WriteDown\Database\Entities\PostTag';
        $this->entity     = 'PostTag';

        // Set the transformer for this model
        $this->response->setTransformer(new PostTagTransformer); // TODO: Inject this
    }

    /**
     * @inheritDoc
     */
    public function delete($postID, $tagID): array
    {
        // Get the relationship
        $postTag = $this->db->getRepository($this->entityRepo)->findOneBy([
            'post_id' => $postID,
            'tag_id'  => $tagID,
        ]);

        // Return a non-successful response if the relationship doesn't exist
        if (!$postTag) {
            return $this->response->build(['Not found.'], false);
        }

        // Remove and respond
        $this->db->remove($postTag);
        $this->db->flush();
        return $this->response->build([]);
    }
}
