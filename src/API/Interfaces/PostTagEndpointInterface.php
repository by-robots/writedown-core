<?php

namespace ByRobots\WriteDown\API\Interfaces;

interface PostTagEndpointInterface extends CRUInterface
{
    /**
     * Delete a post->tag relationship.
     *
     * @param int $postID
     * @param int $tagID
     *
     * @return array
     */
    public function delete($postID, $tagID):array;
}
