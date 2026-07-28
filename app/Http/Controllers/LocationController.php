<?php

namespace App\Http\Controllers;

use App\DTOs\LocationDTO;
use App\Http\Requests\LocationRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService
    ) {}

    /**
     * Store a newly created location.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search');
        $notPaginate = $request->boolean('not_paginate'); // reads "true"/"1" string as real boolean

        $locations = $this->locationService->getAll($perPage, $page, $search, $notPaginate);

        return response()->json([
            'message' => 'Locations fetched successfully.',
            'data' => $locations,
        ]);
    }
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
