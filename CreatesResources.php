<?php

namespace Tests;

use Doctrine\ORM\EntityManager;
use Faker\Factory;
use WriteDown\Entities\Post;

class CreatesResources
{
    /**
     * Fake data generator.
     *
     * @var Faker\Factory
     */
    public $faker;

    /**
     * The database.
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $db;

    /**
     * Set-up.
     *
     * @return void
     */
    public function __construct(EntityManager $db)
    {
        $this->db    = $db;
        $this->faker = Factory::create();
    }

    /**
     * Persist an object.
     *
     * @param mixed $entity
     *
     * @return void
     */
    public function persist($entity)
    {
        $this->db->persist($entity);
    }

    /**
     * Perform a flush operation on the EntityManager.
     *
     * @return void
     */
    public function flush()
    {
        $this->db->flush();
    }

    /**
     * Create a test post.
     *
     * @return WriteDown\Entities\Post
     */
    public function post()
    {
        $post = new Post;

        $post->title      = $this->faker->sentence;
        $post->slug       = $this->faker->slug;
        $post->body       = $this->faker->paragraph;
        $this->publish_at = new \DateTime('now');
        $this->persist($post);
        $this->flush();

        return $post;
    }
}
