<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class UnprocessableEntityResponse extends ResponseFactory implements Reusable
{

    public function build(): Response
    {

        $response = Schema::object()->properties(
                Schema::string('message')->example('Validation failed!'),
                Schema::object('errors')->additionalProperties(
                                Schema::array()->items(Schema::string())
                        )
                        ->example(['field' => ['The field is required!']])
        );

        return Response::unprocessableEntity('Unprocessable entity')
                        ->content(MediaType::json()->schema($response))
        ;
    }
}
