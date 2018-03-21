<?php

namespace WriteDown\Entities;

/**
 * @Entity(repositoryClass="WriteDown\Repositories\User")
 * @Table(name="users")
 * @HasLifecycleCallbacks
 */
class User extends Base
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="string", unique=true) */
    protected $email;

    /** @Column(type="text") */
    protected $password;

    /**
     * Contains the validation rules for the entity.
     *
     * @var array
     */
    protected $rules = [
        'email'    => ['required'],
        'password' => ['required'],
    ];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];
}
