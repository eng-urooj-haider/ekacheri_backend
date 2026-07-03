<?php

namespace App\Http\Controllers;

use App\DTOs\CityDTO;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CityService $cityService)
    {
        $cities =  $cityService->getAll();
        return response()->json([
            'message' => 'Cities fetched successfully.',
            'data'    => $cities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request, CityService $cityService)
    {
        $request->validated();
        $dto = CityDTO::fromRequest($request->validated());
        $city = $cityService->save($dto);

        return response()->json([
            'message' => 'City created successfully.',
            'data'    => $city,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit($id, CityService $cityService)
{
    $city = $cityService->getCity($id);

    return response()->json([
        'data' => $city,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
