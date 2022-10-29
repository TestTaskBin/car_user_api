<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Car;

class CarCRUDTest extends TestCase
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

    public function test_cars_index_response()
    {
        $response = $this->get(route('cars.index'));

        $response->assertOk();

        /**
         * @see \Database\Seeders\DatabaseSeeder
         */
        $response->assertJsonCount(10, 'data');
    }

    public function test_show_one_car_response()
    {
        $car = Car::factory()->create();

        $response = $this->get(route('cars.show', ['car' => $car->car_id]));

        $response->assertOk();
        $response->assertExactJson(['data' => [
                'car_id' => $car->car_id,
                'reg_num' => $car->reg_num,
                'model' => $car->model,
                'car_user_id' => $car->car_user_id,
                'created_at' => $car->created_at,
                'updated_at' => $car->updated_at,
        ]]);
    }

    public function test_create_one_car()
    {
        $data = ['reg_num' => 'AA1234BB', 'model' => 'Toyota'];

        $response = $this->post(route('cars.store'), $data);

        $response->assertCreated();
        $response->assertJson(['data' => [
                'reg_num' => $data['reg_num'],
                'model' => $data['model'],
                'car_user_id' => null,
        ]]);
    }

    public function test_update_one_car()
    {
        $car = Car::factory()->create();
        $data = ['reg_num' => 'AA1234BB', 'model' => 'Toyota'];

        $response = $this->put(route('cars.update', ['car' => $car->car_id]), $data);

        $response->assertOk();
        $response->assertJson(['data' => [
                'car_id' => $car->car_id,
                'reg_num' => $data['reg_num'],
                'model' => $data['model'],
                'car_user_id' => null,
        ]]);
    }

    public function test_delete_one_car()
    {
        $car = Car::factory()->create();

        $response = $this->delete(route('cars.destroy', ['car' => $car->car_id]));

        $response->assertOk();
        $this->assertModelMissing($car);
    }
}
