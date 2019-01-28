<?php

namespace ByRobots\WriteDown\Database\Entities;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * @Entity(repositoryClass="ByRobots\WriteDown\Database\Repositories\Tag")
 * @Table(name="tags")
 * @HasLifecycleCallbacks
 */
class Tag extends Base
{
    use EntityTimestamps;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="string") */
    public $name;

    /**
     * Contains the validation rules for the entity.
     *
     * @var array
     */
    protected $rules = [
        'name' => [
            'present',
            'not_empty',
            'valid_slug',
            'unique_in_database' => [
                'repository' => 'ByRobots\WriteDown\Database\Entities\Tag',
            ],
        ],
    ];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * On deletion remove any post_tag entries relating to this tag.
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
            'tag_id' => $this->id,
        ]);

        foreach ($relationships as $relationship) {
            $entityManager->remove($relationship);
        }

        $entityManager->flush();
    }
}
