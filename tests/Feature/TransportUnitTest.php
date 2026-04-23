<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransportUnitTest extends TestCase
{
	use RefreshDatabase;

    /**
     * Creation of transport units.
     */
    public function test_can_create_transport_unit(): void
	{
		$response = $this->postJson('/api/transport-units', [
			'name' => 'Test Truck',
			'type' => 'truck',
		]);

		$response->assertStatus(201);
		$this->assertDatabaseHas('transport_units', [
			'name' => 'Test Truck',
			'type' => 'truck',
		]);
	}

	public function test_create_with_invalid_type(): void
	{
		$response = $this->postJson('/api/transport-units', [
			'name' => 'Correct name',
			'type' => 'Minivan',
		]);

		$response->assertStatus(422);
	}

	/**
	 * Retrieval of transport units.
	 */
	public function test_can_retrieve_transport_units_by_type(): void
	{
		$this->postJson('/api/transport-units', [
			'name' => 'Test Truck',
			'type' => 'truck',
		]);

		$this->postJson('/api/transport-units', [
			'name' => 'Test Trailer',
			'type' => 'trailer',
		]);

		$response = $this->getJson('/api/transport-units?type=truck');

		$response->assertStatus(200)
			->assertJsonFragment(['name' => 'Test Truck', 'type' => 'truck'])
			->assertJsonMissing(['name' => 'Test Trailer']);
	}

	public function test_can_retrieve_transport_units_by_name(): void
	{
		$this->postJson('/api/transport-units', [
			'name' => 'Test Truck',
			'type' => 'truck',
		]);

		$this->postJson('/api/transport-units', [
			'name' => 'Test Trailer',
			'type' => 'trailer',
		]);

		$response = $this->getJson('/api/transport-units?type=trailer&search=Trailer');

		$response->assertStatus(200)
			->assertJsonFragment(['name' => 'Test Trailer', 'type' => 'trailer'])
			->assertJsonMissing(['name' => 'Test Truck']);
	}
}
