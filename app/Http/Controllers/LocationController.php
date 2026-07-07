<?php

namespace App\Http\Controllers;

use App\DTOs\LocationDTO;
use App\Http\Requests\LocationRequest;
use App\Services\LocationService;

class LocationController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService
    ) {}

    /**
     * Store a newly created location.
     */
    public function store(LocationRequest $request)
    {
        $dto = LocationDTO::fromRequest($request->validated());

        $location = $this->locationService->saveLocation($dto);

        return response()->json([
            'message' => 'Location created successfully.',
            'data'    => $location,
        ], 201);
    }

    /**
     * Get a location for editing.
     */
    public function edit(int $id)
    {
        $location = $this->locationService->getLocation($id);

        return response()->json([
            'message' => 'Location retrieved successfully.',
            'data'    => $location,
        ]);
    }

    /**
     * Update an existing location.
     */
    public function update(LocationRequest $request, int $id)
    {
        $dto = LocationDTO::fromRequest($request->validated());

        $location = $this->locationService->updateLocation($id, $dto);

        return response()->json([
            'message' => 'Location updated successfully.',
            'data'    => $location,
        ]);
    }
}
