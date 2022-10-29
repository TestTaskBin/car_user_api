<?php

namespace App\Http\Controllers;

use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\OpenApi\RequestBodies\StoreCarUserRequestBody;
use App\OpenApi\Responses\CarUserListResponse;
use App\OpenApi\Responses\CarUserResponse;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\UnprocessableEntityResponse;
use App\Models\CarUser;
use App\Http\Resources\CarUserResource;
use App\Http\Requests\CarUserUpdateRequest;
use App\Services\Exceptions\ActionDeniedException;

#[OpenApi\PathItem]
class CarUserController extends Controller
{

    /**
     * Display car users list
     *
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'GET', tags: ['users_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: CarUserListResponse::class, statusCode: 200)]
    public function index()
    {
        return CarUserResource::collection(CarUser::all());
    }

    /**
     * Display car  user information
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'GET', tags: ['users_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\RequestBody(factory: StoreCarUserRequestBody::class)]
    #[OpenApi\Response(factory: CarUserResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(int $id)
    {
        return new CarUserResource(CarUser::findOrFail($id));
    }

    /**
     * Create new car user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'POST', tags: ['users_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\RequestBody(factory: StoreCarUserRequestBody::class)]
    #[OpenApi\Response(factory: UnprocessableEntityResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: CarUserResponse::class, statusCode: 200)]
    public function store(CarUserUpdateRequest $request)
    {
        $carUser = CarUser::create($request->validated());
        return new CarUserResource($carUser);
    }

    /**
     * Update car user data
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'PUT', tags: ['users_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: CarUserResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: UnprocessableEntityResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function update(CarUserUpdateRequest $request, int $id)
    {
        $carUser = CarUser::findOrFail($id);
        $carUser->fill($request->validated());
        $carUser->save();
        return new CarUserResource($carUser);
    }

    /**
     * Remove car user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(method: 'DELETE', tags: ['users_crud'], security: 'BearerTokenSecurityScheme')]
    #[OpenApi\Response(factory: EmptyResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: UnprocessableEntityResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function destroy(int $id)
    {
        $carUser = CarUser::findOrFail($id);
        try {
            $carUser->delete();
        } catch (ActionDeniedException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
        return response()->json((object) [], 200);
    }
}
