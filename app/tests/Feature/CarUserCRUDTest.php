<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\CarUser;

class CarUserCRUDTest extends TestCase
{

    use DatabaseMigrations,
        WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();
        /**
         * @see \Database\Seeders\DatabaseSeeder
         */
        $this->runDatabaseMigrations();
        $this->seed();
    }

    public function test_car_users_index_response()
    {
        $response = $this->get(route('car_users.index'));
        $response->assertOk();
        /**
         * @see \Database\Seeders\DatabaseSeeder
         */
        $response->assertJsonCount(20, 'data');
    }

    public function test_show_one_car_user_response()
    {
        $carUser = CarUser::factory()->create();

        $response = $this->get(route('car_users.show', ['car_user' => $carUser->car_user_id]));

        $response->assertOk();
        $response->assertExactJson(['data' => [
                'car_user_id' => $carUser->car_user_id,
                'first_name' => $carUser->first_name,
                'last_name' => $carUser->last_name,
                'created_at' => $carUser->created_at,
                'updated_at' => $carUser->updated_at,
        ]]);
    }

    public function test_create_one_car_user()
    {
        $data = ['first_name' => 'Ёжик', 'last_name' => 'Туманов'];

        $response = $this->post(route('car_users.store'), $data);

        $response->assertCreated();
        $response->assertJson(['data' => [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
        ]]);
    }

    public function test_update_one_car_user()
    {
        $carUser = CarUser::factory()->create();
        $data = ['first_name' => 'Ёжик', 'last_name' => 'Туманов'];

        $response = $this->put(route('car_users.update', ['car_user' => $carUser->car_user_id]), $data);

        $response->assertOk();
        $response->assertJson(['data' => [
                'car_user_id' => $carUser->car_user_id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
        ]]);
    }

    public function test_delete_one_car_user()
    {
        $carUser = CarUser::factory()->create();

        $response = $this->delete(route('car_users.destroy', ['car_user' => $carUser->car_user_id]));

        $response->assertOk();
        $this->assertModelMissing($carUser);
    }
}
