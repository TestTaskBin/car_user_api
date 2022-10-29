<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use App\OpenApi\Schemas\StoreCarUserSchema;

class StoreCarUserRequestBody extends RequestBodyFactory
{

    public function build(): RequestBody
    {
        return RequestBody::create('Car user')
                        ->description('Car user data')
                        ->content(MediaType::json()->schema(StoreCarUserSchema::ref()));
    }
}
