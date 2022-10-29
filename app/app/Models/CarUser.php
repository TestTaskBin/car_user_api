<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\Exceptions\ActionDeniedException;

class CarUser extends Model
{

    use HasFactory;

    protected $primaryKey = 'car_user_id';
    protected $fillable = [
        'first_name',
        'last_name',
    ];

    protected static function booted()
    {
        static::deleting(function (CarUser $entry) {
            if($entry->car()->first()) {
                throw new ActionDeniedException('This deleting is not allowed');
            }
        });
    }
    public function car()
    {
        return $this->hasOne(Car::class, 'car_user_id', 'car_user_id');
    }

}
