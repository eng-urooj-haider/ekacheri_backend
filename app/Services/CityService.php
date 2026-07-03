<?php

namespace App\Services;

use App\DTOs\CityDTO;
use App\Models\City;

class CityService
{
    function getAll()
    {
        return City::all();
    }
    public function save(CityDTO $dto): City
    {
        return City::create($dto->toArray());
    }
    public function getCity($id)
    {
        return City::where('id', $id)->first();
    }
}
