<?php

namespace ByRobots\WriteDown\Database\Entities;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * @Entity(repositoryClass="ByRobots\WriteDown\Database\Repositories\Post")
 * @Table(name="posts")
 * @HasLifecycleCallbacks
 */
class Post extends Base
{
    use EntityTimestamps;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="text", unique=true) */
    public $slug;

    /** @Column(type="text", nullable=true) */
    public $excerpt;

    /** @Column(type="text") */
    public $body;

    /** @Column(name="publish_at", type="datetime", nullable=true) */
    public $publish_at;

    /** @Column(name="detached", type="boolean") */
    public $detached = false;

    /**
     * Contains the validation rules for creation of the entity.
     *
     * @var array
     */
    protected $rules = [
        'title' => ['present', 'not_empty'],
        'body'  => ['present', 'not_empty'],
        'slug'  => [
            'present',
            'not_empty',
            'valid_slug',
            'unique_in_database' => [
                'repository' => 'ByRobots\WriteDown\Database\Entities\Post',
            ],
        ],
    ];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'publish_at', 'detached',
    ];

    /**
     * On deletion remove any post_tag entries relating to this post.
     *
     * @param LifecycleEventArgs $event
     *
     * @throws \Exception
     *
     * @preRemove
     */
    public function removeTagRelationships(LifecycleEventArgs $event)
    {
        $entityManager = $event->getEntityManager();
        $repository    = $entityManager->getRepository('ByRobots\WriteDown\Database\Entities\PostTag');
        $relationships = $repository->findBy([
            'post_id' => $this->id,
        ]);

        foreach ($relationships as $relationship) {
            $entityManager->remove($relationship);
        }

        $entityManager->flush();
    }
}
