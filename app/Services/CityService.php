<?php

namespace App\Services;

use App\DTOs\CityDTO;
use App\Models\City;

class CityService
{
    public function getAll($perPage = 10, $page = 1, $search = null)
    {
        $query =  City::orderBy('created_at','desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }
        return $query->paginate($perPage, ['*'], 'page', $page);

    }

    public function saveCity(CityDTO $dto): City
    {
        return City::create($dto->toArray());
    }

    public function getCity(int $id): City
    {
        return City::findOrFail($id);
    }

    public function updateCity(City $city, CityDTO $dto): City
    {
        $city->update($dto->toArray());

        return $city->fresh();
    }

    public function deleteCity(City $city): void
    {
        $city->delete();
    }
}
