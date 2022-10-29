<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use App\OpenApi\Schemas\CarSchema;

class CarListResponse extends ResponseFactory
{

    public function build(): Response
    {
        $response = Schema::object()->properties(
                Schema::array('data')
                        ->items(CarSchema::ref())
        );

        return Response::ok('Cars list')
//            ->description('')
                        ->content(MediaType::json()->schema($response))
        ;
    }
}
