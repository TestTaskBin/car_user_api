<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class EmptyResponse extends ResponseFactory implements Reusable
{

    public function build(): Response
    {
        return Response::ok('OK')
                        ->content(MediaType::json()->schema(Schema::object()));
    }
}
