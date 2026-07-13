<?php

namespace App\Http\Controllers;

use App\DTOs\DepartmentDTO;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly DepartmentService $service
    ) {}
    public function index()
    {
        $departments =  $this->service->getAll();
        return response()->json([
            'message' => 'Department fetch successfully.',
            'data'    => $departments,
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        $dto = DepartmentDTO::fromRequest($request);
        $dep = $this->service->saveDepartment($dto);

        return response()->json([
            'message' => 'Department created successfully.',
            'data' => $dep,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $location = $this->service->getDepartment($id);

        return response()->json([
            'message' => 'Location retrieved successfully.',
            'data'    => $location,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, int $id)
    {
        $dto = DepartmentDTO::fromRequest($request);

        $location = $this->service->updateDepartment($id, $dto);

        return response()->json([
            'message' => 'Location updated successfully.',
            'data'    => $location,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
