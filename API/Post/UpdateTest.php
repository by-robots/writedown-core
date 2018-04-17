<?php

namespace Tests\API\Post;

use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * When all is well a post should be updated.
     */
    public function testUpdated()
    {
        // Create a post, then update it.
        $post     = $this->resources->post();
        $newTitle = $this->faker->sentence;
        $result   = $this->writedown->api()->post()->update($post->id, [
            'title' => $newTitle,
        ]);

        // Re-retrieve the post from the database and check the change was saved
        $post = $this->writedown->database()->getRepository('WriteDown\Database\Entities\Post')
            ->findOneBy(['id' => $post->id]);

        // Annnnnd check it
        $this->assertTrue($result['success']);
        $this->assertEquals($newTitle, $post->title);
    }

    /**
     * When a post is not found this should be indicated in the response.
     */
    public function testMissing()
    {
        // Attempt to update a post that doesn't exist
        $result = $this->writedown->api()->post()->update(mt_rand(1000, 9999), [
            'title' => $this->faker->sentence,
        ]);

        // Check the result
        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }

    /**
     * Only attributes marked as fillable should be fillable.
     */
    public function testOnlyFillable()
    {
        $post   = $this->resources->post();
        $result = $this->writedown->api()->post()->update($post->id, [
            'not_fillable' => $this->faker->word,
        ]);

        $this->assertFalse(property_exists($result['data'], 'not_fillable'));
    }

    /**
     * When updating a post the slug can not be set to a slug that already
     * exists.
     */
    public function testUniqueSlug()
    {
        // Create two posts
        $firstPost  = $this->resources->post();
        $secondPost = $this->resources->post();

        // Attempt to update $secondPost via the API, setting it's slug to that
        // to that of $firstPost
        $result = $this->writedown->api()->post()->update($secondPost->id, [
            'slug' => $firstPost->slug,
        ]);

        // Check that fails
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('slug', $result['data']);
    }

    /**
     * An empty title should be invalid
     */
    public function testEmptyTitle()
    {
        $post   = $this->resources->post();
        $result = $this->writedown->api()->post()->update($post->id, [
            'title' => '',
        ]);

        // Annnnnd check it
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('title', $result['data']);
    }
}
