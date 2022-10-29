<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Exceptions\ActionDeniedException;

class Car extends Model
{

    use HasFactory;

    protected $primaryKey = 'car_id';
    protected $fillable = [
        'reg_num',
        'model',
        'car_user_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->car_user_id = $query->car_user_id ?? null;
        });
        static::deleting(function (Car $entry) {
            if (!is_null($entry->car_user_id)) {
                throw new ActionDeniedException('This deleting is not allowed');
            }
        });
    }

    public function user()
    {
        return $this->hasOne(CarUser::class, 'car_user_id', 'car_user_id');
    }

    /**
     * @param  Builder  $query
     * @param  Car  $user
     * @return Builder
     */
    public function scopeFree(Builder $query)
    {
        return $query->whereNull('car_user_id');
    }
}
