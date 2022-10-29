<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use App\OpenApi\Schemas\CarUserSchema;

class CarUserResponse extends ResponseFactory
{

    public function build(): Response
    {
        $response = Schema::object()->properties(
                CarUserSchema::ref('data'),
        );

        return Response::ok('Car user data wrapped')
//                        ->description()
                        ->content(MediaType::json()->schema($response));
    }
}
