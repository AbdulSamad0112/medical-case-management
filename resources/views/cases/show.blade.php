<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Breadcrumbs & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider text-teal-600 mb-1">
                    <a href="{{ route('cases.index') }}" class="hover:underline">Medical Cases</a>
                    <span>/</span>
                    <span class="font-mono">{{ $case->case_number }}</span>
                </div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $case->case_number }}</h1>
                    <x-status-badge :status="$case->status" />
                    <x-priority-badge :priority="$case->priority" />
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('cases.index') }}"
                   class="px-3.5 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition">
                    &larr; Back to Cases
                </a>

                @can('update', $case)
                    <a href="{{ route('cases.edit', $case) }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition">
                        Edit Case
                    </a>
                @endcan

                @can('delete', $case)
                    <form method="POST" action="{{ route('cases.destroy', $case) }}"
                          onsubmit="return confirm('Are you sure you want to permanently delete case {{ $case->case_number }}? This operation cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3.5 py-2 border border-rose-300 rounded-lg text-sm font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 transition">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        <!-- Case Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Medical Details (2 cols) -->
            <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
                <h2 class="text-base font-semibold text-slate-900 border-b border-slate-100 pb-3">Clinical Specifications</h2>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Case Identifier</dt>
                        <dd class="mt-1 font-mono font-medium text-slate-900">{{ $case->case_number }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Patient Reference</dt>
                        <dd class="mt-1 font-mono font-medium text-slate-900">{{ $case->patient_reference }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Surgeon Name</dt>
                        <dd class="mt-1 text-slate-900 font-medium">{{ $case->surgeon_name }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Implant Device / System</dt>
                        <dd class="mt-1 text-slate-900 font-medium">{{ $case->implant_type }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Scheduled Surgery Date</dt>
                        <dd class="mt-1 text-slate-900 font-medium">
                            {{ $case->surgery_date ? $case->surgery_date->format('F d, Y') : 'Not scheduled' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Current Priority</dt>
                        <dd class="mt-1">
                            <x-priority-badge :priority="$case->priority" />
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Audit Trail & Creator Info (1 col) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
                <h2 class="text-base font-semibold text-slate-900 border-b border-slate-100 pb-3">Audit Details</h2>

                <div class="space-y-4 text-xs">
                    <div>
                        <div class="text-slate-400 font-medium uppercase tracking-wider">Internal Record ID</div>
                        <div class="font-mono text-slate-700 font-medium mt-0.5">#{{ $case->id }}</div>
                    </div>

                    <div>
                        <div class="text-slate-400 font-medium uppercase tracking-wider">Created By</div>
                        <div class="text-slate-900 font-medium mt-0.5">{{ $case->creator?->name ?? 'System User' }}</div>
                        <div class="text-slate-500 truncate">{{ $case->creator?->email ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <div class="text-slate-400 font-medium uppercase tracking-wider">Registered At</div>
                        <div class="text-slate-700 mt-0.5">{{ $case->created_at->format('M d, Y h:i A') }}</div>
                    </div>

                    <div>
                        <div class="text-slate-400 font-medium uppercase tracking-wider">Last Modified</div>
                        <div class="text-slate-700 mt-0.5">{{ $case->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>

                @if (!auth()->user()->isAdmin())
                    <div class="pt-4 border-t border-slate-100">
                        <span class="inline-flex items-center text-[11px] text-slate-500">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Read-only Viewer permissions
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
