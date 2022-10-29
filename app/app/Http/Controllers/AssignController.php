<?php

namespace App\Http\Controllers;

use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\OpenApi\Responses\CarListResponse;
use App\OpenApi\Responses\CarUserListResponse;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\UnprocessableEntityResponse;
use App\Models\Car;
use App\Models\CarUser;
use App\Services\CarAssignService;
use App\Services\Exceptions\CarAssignException;
use App\Http\Resources\CarResource;
use App\Http\Resources\CarUserResource;

#[OpenApi\PathItem]
class AssignController extends Controller
{

    /**
     * Show full list of free users
     */
    #[OpenApi\Operation(method: 'GET', tags: ['assign'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: CarUserListResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function freeUsers(CarAssignService $service)
    {
        return CarUserResource::collection(
                        $service->getPossibleUsers()
        );
    }

    /**
     * Show full list of free cars
     * @param int $user
     */
    #[OpenApi\Operation(method: 'GET', tags: ['assign'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: CarListResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function freeCars(CarAssignService $service)
    {
        return CarResource::collection(
                        $service->getPossibleCars()
        );
    }

    /**
     * Assign car to user
     * @param int $car
     * @param int $user
     */
    #[OpenApi\Operation(method: 'GET', tags: ['assign'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: EmptyResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnprocessableEntityResponse::class, statusCode: 422)]
    public function assignCar(int $car, int $user, CarAssignService $service)
    {
        try {
            $service->assingCarToUser(Car::findOrFail($car), CarUser::findOrFail($user));
        } catch (CarAssignException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
        return response()->json((object) [], 200);
    }

    /**
     * Release car from user
     * @param int $car
     * @param int $user
     */
    #[OpenApi\Operation(method: 'GET', tags: ['assign'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: EmptyResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Response(factory: UnprocessableEntityResponse::class, statusCode: 422)]
    public function releaseCar(int $car, int $user, CarAssignService $service)
    {
        try {
            $service->releaseCarFromUser(Car::findOrFail($car), CarUser::findOrFail($user));
        } catch (CarAssignException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
        return response()->json((object) [], 200);
    }
}
