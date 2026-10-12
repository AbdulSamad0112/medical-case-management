<?php

namespace App\Http\Controllers;

use App\Enums\CaseStatus;
use App\Models\MedicalCase;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the medical management dashboard.
     */
    public function index(): View
    {
        $metrics = [
            'total' => MedicalCase::count(),
            'planning' => MedicalCase::where('status', CaseStatus::PLANNING->value)->count(),
            'in_review' => MedicalCase::where('status', CaseStatus::IN_REVIEW->value)->count(),
            'approved' => MedicalCase::where('status', CaseStatus::APPROVED->value)->count(),
            'completed' => MedicalCase::where('status', CaseStatus::COMPLETED->value)->count(),
        ];

        $recentCases = MedicalCase::with('creator')
            ->latest('id')
            ->take(5)
            ->get();

        return view('dashboard', compact('metrics', 'recentCases'));
    }
}
