<?php

namespace ByRobots\WriteDown\Database\Entities;

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
        'name' => ['present', 'not_empty', 'valid_slug', 'unique_in_database' => [
            'repository' => 'ByRobots\WriteDown\Database\Entities\Tag',
        ]],
    ];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
