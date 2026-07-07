<?php

namespace App\Services;

use App\DTOs\LocationDTO;
use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    /**
     * Get all locations.
     */
    public function getAll(): Collection
    {
        return Location::all();
    }

    /**
     * Create a new location.
     */
    public function saveLocation(LocationDTO $dto): Location
    {
        return Location::create($dto->toArray());
    }

    /**
     * Get a single location by ID.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getLocation(int $id): Location
    {
        return Location::findOrFail($id);
    }

    /**
     * Update an existing location.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function updateLocation(int $id, LocationDTO $dto): Location
    {
        $location = Location::findOrFail($id);

        $location->update($dto->toArray());

        return $location->fresh();
    }

    /**
     * Delete a location.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteLocation(int $id): void
    {
        $location = Location::findOrFail($id);

        $location->delete();
    }
}
