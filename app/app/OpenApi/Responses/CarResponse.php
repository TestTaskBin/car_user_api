<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use App\OpenApi\Schemas\CarSchema;

class CarResponse extends ResponseFactory
{

    public function build(): Response
    {
        $response = Schema::object()->properties(
                CarSchema::ref('data'),
        );

        return Response::ok('CarDataWrapped')
//                        ->description()
                        ->content(MediaType::json()->schema($response))
        ;
    }
}
