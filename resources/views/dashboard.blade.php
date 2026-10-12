<x-app-layout>
    <div class="space-y-8">
        <!-- Dashboard Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Clinical Operations Dashboard</h1>
                <p class="text-sm text-slate-500 mt-1">Overview of active surgical implant cases and patient tracking.</p>
            </div>
            @can('create', App\Models\MedicalCase::class)
                <div>
                    <a href="{{ route('cases.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New Case
                    </a>
                </div>
            @endcan
        </div>

        <!-- Metric Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total Cases -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Cases</span>
                    <span class="p-2 rounded-lg bg-slate-100 text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                </div>
                <div class="text-3xl font-bold text-slate-900 mt-3">{{ $metrics['total'] }}</div>
                <div class="text-xs text-slate-400 mt-1">All recorded cases</div>
            </div>

            <!-- Planning -->
            <div class="bg-white p-5 rounded-2xl border border-sky-100 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-sky-700">Planning</span>
                    <span class="p-2 rounded-lg bg-sky-50 text-sky-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                </div>
                <div class="text-3xl font-bold text-sky-900 mt-3">{{ $metrics['planning'] }}</div>
                <div class="text-xs text-sky-600 mt-1">Pre-op preparation</div>
            </div>

            <!-- In Review -->
            <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-amber-700">In Review</span>
                    <span class="p-2 rounded-lg bg-amber-50 text-amber-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>
                </div>
                <div class="text-3xl font-bold text-amber-900 mt-3">{{ $metrics['in_review'] }}</div>
                <div class="text-xs text-amber-600 mt-1">Awaiting clinical approval</div>
            </div>

            <!-- Approved -->
            <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-700">Approved</span>
                    <span class="p-2 rounded-lg bg-emerald-50 text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="text-3xl font-bold text-emerald-900 mt-3">{{ $metrics['approved'] }}</div>
                <div class="text-xs text-emerald-600 mt-1">Cleared for surgery</div>
            </div>

            <!-- Completed -->
            <div class="bg-white p-5 rounded-2xl border border-teal-100 shadow-sm hover:shadow transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-teal-700">Completed</span>
                    <span class="p-2 rounded-lg bg-teal-50 text-teal-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                </div>
                <div class="text-3xl font-bold text-teal-900 mt-3">{{ $metrics['completed'] }}</div>
                <div class="text-xs text-teal-600 mt-1">Surgery performed</div>
            </div>
        </div>

        <!-- Recent Cases Section -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Recent Medical Cases</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Most recently created or updated implant case files</p>
                </div>
                <a href="{{ route('cases.index') }}" class="text-sm font-medium text-teal-600 hover:text-teal-700 flex items-center space-x-1">
                    <span>View All Cases</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50/75 text-xs uppercase font-semibold text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-3.5">Case Number</th>
                            <th scope="col" class="px-6 py-3.5">Patient Ref</th>
                            <th scope="col" class="px-6 py-3.5">Surgeon</th>
                            <th scope="col" class="px-6 py-3.5">Implant Type</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5">Priority</th>
                            <th scope="col" class="px-6 py-3.5">Surgery Date</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($recentCases as $case)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-6 py-4 font-mono font-medium text-teal-700">
                                    <a href="{{ route('cases.show', $case) }}" class="hover:underline">
                                        {{ $case->case_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-mono text-slate-600">
                                    {{ $case->patient_reference }}
                                </td>
                                <td class="px-6 py-4 text-slate-900 font-medium">
                                    {{ $case->surgeon_name }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 max-w-xs truncate">
                                    {{ $case->implant_type }}
                                </td>
                                <td class="px-6 py-4">
                                    <x-status-badge :status="$case->status" />
                                </td>
                                <td class="px-6 py-4">
                                    <x-priority-badge :priority="$case->priority" />
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $case->surgery_date ? $case->surgery_date->format('M d, Y') : '—' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('cases.show', $case) }}"
                                       class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-md transition">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                    No cases recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
