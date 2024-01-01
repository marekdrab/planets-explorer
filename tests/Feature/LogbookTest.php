<?php

namespace Tests\Feature;

use App\Models\Logbook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogbookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase, WithFaker;

    public function testLogbookCreation()
    {
        $formData = [
            'mood' => $this->faker->word,
            'weather' => $this->faker->word,
            'gps_location' => $this->faker->latitude . ', ' . $this->faker->longitude,
            'note' => $this->faker->sentence,
        ];

        $response = $this->postJson('/api/logbooks', $formData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'mood',
            'weather',
            'gps_location',
            'note',
            'id', // assuming your response includes the id
            'created_at',
            'updated_at',
        ]);
    }

    public function testLogbookCreationWithMissingFields()
    {
        $formData = [
            'mood' => 'Anxious', // Intentionally leaving out other fields
        ];

        $response = $this->postJson('/api/logbooks', $formData);

        $response->assertStatus(422); // HTTP 422 Unprocessable Entity
        $response->assertJsonValidationErrors(['weather', 'gps_location', 'note']);
    }

    public function testLogbookCreationWithInvalidData()
    {
        $formData = [
            'mood' => '', // Empty string, assuming it should be a valid mood
            'weather' => 123, // Invalid type, assuming weather should be a string
            'gps_location' => 123, // Invalid GPS format
            'note' => null, // Assuming note should be a string
        ];

        $response = $this->postJson('/api/logbooks', $formData);

        $response->assertStatus(422); // HTTP 422 Unprocessable Entity
        $response->assertJsonValidationErrors(['mood', 'weather', 'gps_location', 'note']);
    }

    public function testDatabaseStateAfterLogbookCreation()
    {
        $formData = [
            'mood' => 'Relieved',
            'weather' => 'Clear',
            'gps_location' => '36.7783° N, 119.4179° W',
            'note' => 'Found a safe place to rest.',
        ];

        $response = $this->postJson('/api/logbooks', $formData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('logbooks', [
            'mood' => 'Relieved',
            'weather' => 'Clear',
            // Note: 'note' is encrypted, so it won't match directly
        ]);

        // Additional check for the encrypted note if needed
        $logbook = Logbook::latest()->first();
        $this->assertEquals('Found a safe place to rest.', decrypt($logbook->note));
    }
}
