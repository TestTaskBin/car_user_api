<?php

namespace App\Services;

use Exception;
use App\Models\Car;
use App\Models\CarUser;

class CarAssignService
{

    public function getPossibleUsers()
    {
        return CarUser::doesntHave('car')->get();
    }

    public function getPossibleCars()
    {
        return Car::free()->get();
    }

    public function assingCarToUser(Car $car, CarUser $user)
    {
        try {
            $ok = Car::where('car_id', $car->car_id)
                    ->whereNull('car_user_id')
                    ->update(['car_user_id' => $user->car_user_id])
            ;
        } catch (Exception $e) {
            // uniq key violation
            throw new Exceptions\CarAssignException('This assigning is not allowed!');
        }

        if ($ok !== 1) {
            throw new Exceptions\CarAssignException('Assigning failed!');
        }
    }

    public function releaseCarFromUser(Car $car, CarUser $user)
    {
        $ok = Car::where('car_id', $car->car_id)
                ->where('car_user_id', $user->car_user_id)
                ->update(['car_user_id' => null])
        ;

        if ($ok !== 1) {
            throw new Exceptions\CarAssignException('This releasing is not allowed1');
        }
    }
}
