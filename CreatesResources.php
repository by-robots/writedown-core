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
        $this->publish_at = date("Y-m-d H:i:s");
        $this->db->persist($post);
        $this->db->flush();

        return $post;
    }
}
