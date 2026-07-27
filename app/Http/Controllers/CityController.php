<?php

namespace App\Http\Controllers;

use App\DTOs\CityDTO;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(
        private readonly CityService $cityService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page    = $request->input('page', 1);
        $search  = $request->input('search'); // NEW

        $Cities = $this->cityService->getAll($perPage, $page, $search); // NEW: pass search

        return response()->json([
            'message' => 'Cities fetched successfully.',
            'data'    => $Cities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        $dto = CityDTO::fromRequest($request->validated());

        $city = $this->cityService->saveCity($dto);

        return response()->json([
            'message' => 'City created successfully.',
            'data' => $city,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return response()->json([
            'message' => 'City retrieved successfully.',
            'data'    => $city,
        ]);
    }
    public function edit(int $id)
    {
        $location = $this->cityService->getCity($id);

        return response()->json([
            'message' => 'City retrieved successfully.',
            'data'    => $location,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city)
    {
        $dto = CityDTO::fromRequest($request->validated());

        $updated = $this->cityService->updateCity($city, $dto);

        return response()->json([
            'message' => 'City updated successfully.',
            'data' => $updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $this->cityService->deleteCity($city);

        return response()->json([
            'message' => 'City deleted successfully.',
        ]);
    }
}
