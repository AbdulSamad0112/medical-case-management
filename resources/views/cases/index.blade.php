<x-app-layout>
    <div class="space-y-6">
        <!-- Page Title & Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Medical Case Registry</h1>
                <p class="text-sm text-slate-500 mt-1">Manage, search, and track surgical device implant cases.</p>
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

        <!-- Search & Filter Controls Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('cases.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <!-- Search by Case Number -->
                <div>
                    <label for="case_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">
                        Case Number
                    </label>
                    <input type="text"
                           name="case_number"
                           id="case_number"
                           value="{{ request('case_number') }}"
                           placeholder="e.g. CASE-1001"
                           class="block w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                </div>

                <!-- Search by Surgeon Name -->
                <div>
                    <label for="surgeon_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">
                        Surgeon Name
                    </label>
                    <input type="text"
                           name="surgeon_name"
                           id="surgeon_name"
                           value="{{ request('surgeon_name') }}"
                           placeholder="e.g. Dr. Chen"
                           class="block w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                </div>

                <!-- Filter by Status -->
                <div>
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">
                        Status
                    </label>
                    <select name="status"
                            id="status"
                            class="block w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">All Statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                                {{ $status->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Priority -->
                <div>
                    <label for="priority" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">
                        Priority
                    </label>
                    <select name="priority"
                            id="priority"
                            class="block w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">All Priorities</option>
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority->value }}" {{ request('priority') === $priority->value ? 'selected' : '' }}>
                                {{ $priority->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Action Buttons -->
                <div class="flex items-center space-x-2">
                    <button type="submit"
                            class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Filter
                    </button>
                    @if (request()->hasAny(['case_number', 'surgeon_name', 'status', 'priority']))
                        <a href="{{ route('cases.index') }}"
                           title="Reset Filters"
                           class="px-3 py-2.5 border border-slate-300 text-slate-600 hover:text-slate-900 hover:bg-slate-50 rounded-lg text-sm font-medium transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Cases Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50/75 text-xs uppercase font-semibold text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-3.5">Case Number</th>
                            <th scope="col" class="px-6 py-3.5">Patient Code</th>
                            <th scope="col" class="px-6 py-3.5">Surgeon</th>
                            <th scope="col" class="px-6 py-3.5">Implant System</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5">Priority</th>
                            <th scope="col" class="px-6 py-3.5">Surgery Date</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($cases as $case)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-6 py-4 font-mono font-medium text-teal-700">
                                    <a href="{{ route('cases.show', $case) }}" class="hover:underline">
                                        {{ $case->case_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-mono text-slate-600">
                                    {{ $case->patient_reference }}
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ $case->surgeon_name }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 max-w-xs truncate" title="{{ $case->implant_type }}">
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
                                    <div class="inline-flex items-center justify-end space-x-2">
                                        <!-- View Action (All roles) -->
                                        <a href="{{ route('cases.show', $case) }}"
                                           title="View Details"
                                           class="px-2.5 py-1 text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                                            View
                                        </a>

                                        <!-- Edit Action (Admin only) -->
                                        @can('update', $case)
                                            <a href="{{ route('cases.edit', $case) }}"
                                               title="Edit Case"
                                               class="px-2.5 py-1 text-xs font-medium text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-md transition">
                                                Edit
                                            </a>
                                        @endcan

                                        <!-- Delete Action (Admin only) -->
                                        @can('delete', $case)
                                            <form method="POST" action="{{ route('cases.destroy', $case) }}"
                                                  onsubmit="return confirm('Delete case {{ $case->case_number }}?');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Delete Case"
                                                        class="px-2.5 py-1 text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-md transition">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="max-w-sm mx-auto space-y-2">
                                        <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        <div class="text-sm font-medium text-slate-900">No matching medical cases</div>
                                        <p class="text-xs text-slate-500">
                                            Try adjusting your search criteria or clear active filters to see all cases.
                                        </p>
                                        @if (request()->hasAny(['case_number', 'surgeon_name', 'status', 'priority']))
                                            <div class="pt-2">
                                                <a href="{{ route('cases.index') }}"
                                                   class="inline-flex items-center text-xs font-medium text-teal-600 hover:text-teal-700">
                                                    Clear all filters &rarr;
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar with Query String Preservation -->
            @if ($cases->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $cases->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
