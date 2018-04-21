<?php

namespace WriteDown\Database\Entities;

/**
 * @Entity(repositoryClass="WriteDown\Database\Repositories\User")
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
    public $email;

    /** @Column(type="text") */
    protected $password;

    /** @Column(type="text", unique=true, nullable=true) */
    public $token;

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
    protected $fillable = ['email', 'password', 'token'];

    /**
     * Attributes that should not be accessible to the object.
     *
     * @var array
     */
    protected $hidden = ['token'];

    /**
     * When the password is set, hash it.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}
