<?php

namespace Tests\API\Tag;

use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * Tests that a tag can be created when the data is valid.
     */
    public function testCreated()
    {
        // Create a tag
        $name = $this->faker->word;
        $tag  = $this->writedown->api()->tag()->create([
            'name' => $name,
        ]);

        // Check we have something
        $this->assertTrue($tag['success']);
        $this->assertEquals($name, $tag['data']->name);
    }

    /**
     * Tests that a tag can't be created without a name.
     */
    public function testValidationNoName()
    {
        // Attempt to create a tag without a name.
        $result = $this->writedown->api()->tag()->create([]);

        // Check the error was as expected
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('name', $result['data']);
    }

	/**
	 * Test that a tag's name needs to be a valid slug.
	 */
	public function testValidSlug()
	{
		// Attempt to create a tag with an invalid name.
		$result = $this->writedown->api()->tag()->create([
			'name' => 'Bad Tag',
		]);

		// Check the error was as expected
		$this->assertFalse($result['success']);
		$this->assertArrayHasKey('name', $result['data']);
	}

    /**
     * Test columns that aren't marked as fillable can't be populated.
     */
    public function testOnlyFillable()
    {
        $result = $this->writedown->api()->tag()->create([
            'name'         => $this->faker->word,
            'not_fillable' => $this->faker->word,
        ]);

        $this->assertTrue($result['success']);
        $this->assertFalse(property_exists($result['data'], 'not_fillable'));
    }

    /**
     * The tag's name must be unique.
     */
    public function testNameUnique()
    {
        // Create a tag
        $tag = $this->resources->tag();

        // Try to create another tag with the same name
        $result = $this->writedown->api()->tag()->create([
            'name' => $tag->name,
        ]);

        // Check that the errors expected are returned
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('name', $result['data']);
    }
}
