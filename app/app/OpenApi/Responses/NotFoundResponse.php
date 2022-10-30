<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class NotFoundResponse extends ResponseFactory implements Reusable
{

    public function build(): Response
    {

        $response = Schema::object()->properties(
                Schema::string('message')->example('No query results for model [App\\Models\\XXX] 12345'),
        );

        return Response::notFound('NotFound')
                        ->content(MediaType::json()->schema($response))
        ;
    }
}
