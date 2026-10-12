<?php

namespace App\Http\Controllers\Api;

use App\Enums\CasePriority;
use App\Enums\CaseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseRequest;
use App\Http\Requests\UpdateCaseRequest;
use App\Http\Resources\CaseResource;
use App\Models\MedicalCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CaseApiController extends Controller
{
    /**
     * Return the reference data (statuses & priorities) used by case forms.
     */
    public function options(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'statuses' => CaseStatus::values(),
                'priorities' => CasePriority::values(),
            ],
            'message' => 'Case options retrieved successfully.',
        ], 200);
    }

    /**
     * Display a listing of medical cases.
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->user()->cannot('viewAny', MedicalCase::class)) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'This action is unauthorized.',
            ], 403);
        }

        $query = MedicalCase::with('creator');

        if ($request->filled('case_number')) {
            $query->where('case_number', 'like', '%' . trim($request->case_number) . '%');
        }

        if ($request->filled('surgeon_name')) {
            $query->where('surgeon_name', 'like', '%' . trim($request->surgeon_name) . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', trim($request->status));
        }

        if ($request->filled('priority')) {
            $query->where('priority', trim($request->priority));
        }

        $perPage = max(1, min(50, (int) $request->input('per_page', 10)));
        $paginated = $query->latest('id')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => CaseResource::collection($paginated->items()),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
            'message' => 'Cases retrieved successfully.',
        ], 200);
    }

    /**
     * Store a newly created medical case.
     */
    public function store(StoreCaseRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        $case = MedicalCase::create($data);
        $case->load('creator');

        return response()->json([
            'success' => true,
            'data' => new CaseResource($case),
            'message' => 'Medical case created successfully.',
        ], 201);
    }

    /**
     * Display the specified medical case.
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $case = MedicalCase::with('creator')->find($id);

        if (!$case) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Medical case not found.',
            ], 404);
        }

        if ($request->user()->cannot('view', $case)) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'This action is unauthorized.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => new CaseResource($case),
            'message' => 'Medical case retrieved successfully.',
        ], 200);
    }

    /**
     * Update the specified medical case.
     */
    public function update(UpdateCaseRequest $request, int $id): JsonResponse
    {
        $case = MedicalCase::find($id);

        if (!$case) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Medical case not found.',
            ], 404);
        }

        if ($request->user()->cannot('update', $case)) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'This action is unauthorized.',
            ], 403);
        }

        $case->update($request->validated());
        $case->load('creator');

        return response()->json([
            'success' => true,
            'data' => new CaseResource($case),
            'message' => 'Medical case updated successfully.',
        ], 200);
    }

    /**
     * Remove the specified medical case.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $case = MedicalCase::find($id);

        if (!$case) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Medical case not found.',
            ], 404);
        }

        if ($request->user()->cannot('delete', $case)) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'This action is unauthorized.',
            ], 403);
        }

        $case->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Medical case deleted successfully.',
        ], 200);
    }
}
