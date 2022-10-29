<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Car;
use App\Models\CarUser;

class CarAssigningTest extends TestCase
{

    use DatabaseMigrations,
        WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
        /**
         * @see \Database\Seeders\DatabaseSeeder
         */
        $this->seed();
    }

    public function test_get_free_users_for_car()
    {
        foreach (Car::whereNotIn('car_id', [2])->get() as $car) {
            $car->car_user_id = $car->car_id;
            $car->save();
        }

        $response = $this->get(route('free_users'));

        $response->assertOk();
        $this->assertNotEmpty($response->json('data'));
        foreach ($response->json('data') as $entry) {
            $this->assertContains($entry['car_user_id'], [2, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]);
        }
    }

    public function test_get_free_cars_for_user()
    {
        foreach (Car::whereNotIn('car_id', [3, 5])->get() as $car) {
            $car->car_user_id = $car->car_id;
            $car->save();
        }

        $response = $this->get(route('free_cars'));

        $response->assertOk();
        $this->assertNotEmpty($response->json('data'));
        foreach ($response->json('data') as $entry) {
            $this->assertNotContains($entry['car_user_id'], [3, 5]);
        }
    }

    public function test_no_free_cars_for_user()
    {
        foreach (Car::all() as $car) {
            $car->car_user_id = $car->car_id;
            $car->save();
        }

        $response = $this->get(route('free_cars'));

        $response->assertOk();
        $this->assertEmpty($response->json('data'));
    }

    public function test_assign_car_to_user_successfully()
    {

        $response = $this->get(route('assign_car', ['car' => 1, 'user' => 4]));

        $response->assertOk();
        $car = Car::find(1);
        $this->assertEquals(4, $car->car_user_id);
    }

    public function test_release_car_from_user_successfully()
    {
        Car::where('car_id', 6)->update(['car_user_id' => 4]);

        $response = $this->get(route('release_car', ['car' => 6, 'user' => 4]));

        $response->assertOk();
        $car = Car::find(6);
        $this->assertNull($car->car_user_id);
    }

    public function test_assign_car_twice_failed()
    {
        Car::where('car_id', 6)->update(['car_user_id' => 4]);

        $response = $this->get(route('assign_car', ['car' => 6, 'user' => 9]));

        $response->assertStatus(422);
        $car = Car::find(6);
        $this->assertEquals(4, $car->car_user_id);
    }

    public function test_assign_to_user_twice_failed()
    {
        Car::where('car_id', 6)->update(['car_user_id' => 4]);

        $response = $this->get(route('assign_car', ['car' => 3, 'user' => 4]));

        $response->assertStatus(422);
        $car = Car::find(6);
        $this->assertEquals(4, $car->car_user_id);
    }

    public function test_release_car_from_user_failed()
    {
        Car::where('car_id', 6)->update(['car_user_id' => 4]);

        $response = $this->get(route('assign_car', ['car' => 6, 'user' => 43]));

        $response->assertStatus(404);
        $car = Car::find(6);
        $this->assertEquals(4, $car->car_user_id);
    }

    public function test_cannot_delete_assigned_car()
    {
        Car::where('car_id', 6)->update(['car_user_id' => 4]);

        $response = $this->delete(route('cars.destroy', ['car' => 6]));

        $response->assertStatus(422);
        $car = Car::find(6);
        $this->assertEquals(4, $car->car_user_id);
    }

    public function test_cannot_delete_user_if_car_assigned()
    {
        Car::where('car_id', 6)->update(['car_user_id' => 4]);

        $response = $this->delete(route('car_users.destroy', ['car_user' => 4]));

        $response->assertStatus(422);
        $car = Car::find(6);
        $this->assertEquals(4, $car->car_user_id);
    }
}
