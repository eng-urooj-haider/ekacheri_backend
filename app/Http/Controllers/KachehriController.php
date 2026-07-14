<?php

namespace App\Http\Controllers;

use App\DTOs\KacheriDTO;
use App\Http\Requests\KacheriRequest;
use App\Services\KacheriService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KacheriController extends Controller
{
    public function __construct(private KacheriService $kacheriService) {}

    public function index(): JsonResponse
    {
        return response()->json($this->kacheriService->getAll());
    }

    public function store(KacheriRequest $request): JsonResponse
    {
        $dto = KacheriDTO::fromRequest($request);
        $kacheri = $this->kacheriService->save($dto);

        return response()->json($kacheri, 201);
    }

    public function show(int $kacheri): JsonResponse
    {
        return response()->json($this->kacheriService->getById($kacheri));
    }

    public function update(KacheriRequest $request, int $kacheri): JsonResponse
    {
        $dto = KacheriDTO::fromRequest($request);
        $updated = $this->kacheriService->update($kacheri, $dto);

        return response()->json($updated);
    }

    public function destroy(int $kacheri): JsonResponse
    {
        $this->kacheriService->delete($kacheri);

        return response()->json(null, 204);
    }

    /**
     * GET /kacheris/latest-id
     * Used by the frontend for auto-suggesting the next Kachehri Number.
     */
    public function getLatestId(): JsonResponse
    {
        return response()->json(['id' => $this->kacheriService->getLatestId()]);
    }

    /**
     * GET /kacheris/status/{status}
     */
    public function byStatus(string $status): JsonResponse
    {
        return response()->json($this->kacheriService->getByStatus($status));
    }
}
