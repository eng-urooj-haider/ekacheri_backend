<?php

namespace App\Http\Controllers;

use App\DTOs\EkachehriDTO;
use App\Http\Requests\StoreEkachehriRequest;
use App\Http\Requests\UpdateEkachehriRequest;
use App\Services\EkachehriService;
use Illuminate\Http\JsonResponse;

class EkachehriController extends Controller
{
    public function __construct(
        private readonly EkachehriService $ekachehriService
    ) {}

    // GET /ekachehris  → used by the list page
    public function index(): JsonResponse
    {
        $ekachehris = $this->ekachehriService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'E-Kachehris fetched successfully.',
            'data' => $ekachehris,
        ]);
    }

    // GET /ekachehris/{id} → used by useKacheriForm's getEkachehri(id) in edit mode
    public function show(int $id): JsonResponse
    {
        $ekachehri = $this->ekachehriService->getById($id);

        return response()->json([
            'success' => true,
            'message' => 'E-Kachehri fetched successfully.',
            'data' => $ekachehri,
        ]);
    }

    // GET /ekachehris/latest-id → used by useKacheriForm's getLatestId()
    public function latestId(): JsonResponse
    {
        $id = $this->ekachehriService->getLatestId();

        return response()->json([
            'data' => ['id' => $id],
        ]);
    }

    // POST /ekachehris → used by storeEkachehri()
    public function store(StoreEkachehriRequest $request): JsonResponse
    {
        $dto = EkachehriDTO::fromArray($request->validated());

        $ekachehri = $this->ekachehriService->create($dto);

        return response()->json([
            'success' => true,
            'message' => 'E-Kachehri created successfully.',
            'data' => $ekachehri,
        ], 201);
    }
    public function edit(int $id)
    {
        $ekachehri = $this->ekachehriService->getById($id);

        return response()->json([
            'data'    => $ekachehri,
        ]);
    }
    // PUT /ekachehris/{id} → used by updateEkachehri(id, payload)
    public function update(UpdateEkachehriRequest $request, int $id): JsonResponse
    {
        $dto = EkachehriDTO::fromArray($request->validated());

        $ekachehri = $this->ekachehriService->update($id, $dto);

        return response()->json([
            'success' => true,
            'message' => 'E-Kachehri updated successfully.',
            'data' => $ekachehri,
        ]);
    }

    // DELETE /ekachehris/{id}
    public function destroy(int $id): JsonResponse
    {
        $this->ekachehriService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'E-Kachehri deleted successfully.',
        ]);
    }
}
