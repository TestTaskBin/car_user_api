<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use App\OpenApi\Schemas\StoreCarSchema;

class StoreCarRequestBody extends RequestBodyFactory
{

    public function build(): RequestBody
    {
        return RequestBody::create('Car')
                        ->description('Car data')
                        ->content(MediaType::json()->schema(StoreCarSchema::ref()));
    }
}
