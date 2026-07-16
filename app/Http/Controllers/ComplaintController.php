<?php

namespace App\Http\Controllers;

use App\DTOs\ComplaintDTO;
use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use App\Services\ComplaintService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private readonly ComplaintService $service
    ) {}
    public function index()
    {
         $complaints = $this->service->getAll();

        return response()->json([
            'message' => 'Cities fetched successfully.',
            'data'    => $complaints,
        ]);
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
    public function store(StoreComplaintRequest $request): JsonResponse
    {
        $dto = ComplaintDTO::fromArray($request->validated());

        $complaint = $this->service->create($dto);

        return response()->json([
            'success' => true,
            'message' => 'Complaint created successfully.',
            'data' => $complaint,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }

    public function findUuid(string $uuid): JsonResponse
    {
        $complaint = Complaint::find($uuid);

        if (!$complaint) {
            return response()->json([
                'success' => false,
                'message' => 'Complaint not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Complaint retrieved successfully.',
            'data'    => $complaint,
        ]);
    }
}
