<?php

namespace App\Http\Controllers;

use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\OpenApi\RequestBodies\StoreCarRequestBody;
use App\OpenApi\Responses\CarListResponse;
use App\OpenApi\Responses\CarResponse;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\UnprocessableEntityResponse;
use App\Models\Car;
use App\Http\Resources\CarResource;
use App\Http\Requests\CarUpdateRequest;
use App\Services\Exceptions\ActionDeniedException;

#[OpenApi\PathItem]
class CarController extends Controller
{

    /**
     * Display cars list
     *
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'GET', tags: ['cars_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: CarListResponse::class, statusCode: 200)]
    public function index()
    {
        return CarResource::collection(Car::all());
    }

    /**
     * Display car data
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'GET', tags: ['cars_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: CarResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(int $id)
    {
        return new CarResource(Car::findOrFail($id));
    }

    /**
     * Create new car
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'POST', tags: ['cars_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\RequestBody(factory: StoreCarRequestBody::class)]
    #[OpenApi\Response(factory: CarResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: UnprocessableEntityResponse::class, statusCode: 422)]
    public function store(CarUpdateRequest $request)
    {
        $car = Car::create($request->validated());
        return new CarResource($car);
    }

    /**
     * Update car data
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'PUT', tags: ['cars_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\RequestBody(factory: StoreCarRequestBody::class)]
    #[OpenApi\Response(factory: CarResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: UnprocessableEntityResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function update(CarUpdateRequest $request, int $id)
    {
        $car = Car::findOrFail($id);
        $car->fill($request->validated());
        $car->save();
        return new CarResource($car);
    }

    /**
     * Remove car
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'DELETE', tags: ['cars_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: EmptyResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: UnprocessableEntityResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function destroy(int $id)
    {
        $car = Car::findOrFail($id);
        try {
            $car->delete();
        } catch (ActionDeniedException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
        return response()->json((object) [], 200);
    }
}
