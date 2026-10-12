<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Breadcrumb / Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider text-teal-600 mb-1">
                    <a href="{{ route('cases.index') }}" class="hover:underline">Medical Cases</a>
                    <span>/</span>
                    <span>New Case</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Register New Medical Case</h1>
            </div>
            <a href="{{ route('cases.index') }}"
               class="text-sm font-medium text-slate-600 hover:text-slate-900 flex items-center space-x-1">
                <span>&larr; Back to Cases</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
            <form method="POST" action="{{ route('cases.store') }}">
                @include('cases._form', ['case' => $case])
            </form>
        </div>
    </div>
</x-app-layout>
