<?php

namespace App\Http\Controllers;

use App\Enums\CasePriority;
use App\Enums\CaseStatus;
use App\Http\Requests\StoreCaseRequest;
use App\Http\Requests\UpdateCaseRequest;
use App\Models\MedicalCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CaseController extends Controller
{
    /**
     * Display a listing of the medical cases.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', MedicalCase::class);

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

        $cases = $query->latest('id')->paginate(10)->withQueryString();

        $statuses = CaseStatus::cases();
        $priorities = CasePriority::cases();

        return view('cases.index', compact('cases', 'statuses', 'priorities'));
    }

    /**
     * Show the form for creating a new medical case.
     */
    public function create(): View
    {
        $this->authorize('create', MedicalCase::class);

        $case = new MedicalCase();
        $statuses = CaseStatus::cases();
        $priorities = CasePriority::cases();

        return view('cases.create', compact('case', 'statuses', 'priorities'));
    }

    /**
     * Store a newly created medical case in storage.
     */
    public function store(StoreCaseRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        $case = MedicalCase::create($data);

        return redirect()->route('cases.show', $case)
            ->with('success', "Medical case {$case->case_number} created successfully.");
    }

    /**
     * Display the specified medical case.
     */
    public function show(int $id): View
    {
        $case = MedicalCase::with('creator')->findOrFail($id);

        $this->authorize('view', $case);

        return view('cases.show', compact('case'));
    }

    /**
     * Show the form for editing the specified medical case.
     */
    public function edit(int $id): View
    {
        $case = MedicalCase::findOrFail($id);

        $this->authorize('update', $case);

        $statuses = CaseStatus::cases();
        $priorities = CasePriority::cases();

        return view('cases.edit', compact('case', 'statuses', 'priorities'));
    }

    /**
     * Update the specified medical case in storage.
     */
    public function update(UpdateCaseRequest $request, int $id): RedirectResponse
    {
        $case = MedicalCase::findOrFail($id);

        $this->authorize('update', $case);

        $case->update($request->validated());

        return redirect()->route('cases.show', $case)
            ->with('success', "Medical case {$case->case_number} updated successfully.");
    }

    /**
     * Remove the specified medical case from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $case = MedicalCase::findOrFail($id);

        $this->authorize('delete', $case);

        $caseNumber = $case->case_number;
        $case->delete();

        return redirect()->route('cases.index')
            ->with('success', "Medical case {$caseNumber} deleted successfully.");
    }
}
