@csrf
@if ($case->exists)
    @method('PUT')
@endif

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Case Number -->
        <div>
            <label for="case_number" class="block text-sm font-semibold text-slate-700">
                Case Number <span class="text-rose-500">*</span>
            </label>
            <div class="mt-1">
                <input type="text"
                       name="case_number"
                       id="case_number"
                       value="{{ old('case_number', $case->case_number) }}"
                       required
                       placeholder="e.g. CASE-1001"
                       class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm font-mono @error('case_number') border-rose-300 ring-rose-300 @enderror">
            </div>
            <p class="mt-1 text-xs text-slate-400">Unique alphanumeric tracking code.</p>
            @error('case_number')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Patient Reference -->
        <div>
            <label for="patient_reference" class="block text-sm font-semibold text-slate-700">
                Patient Reference <span class="text-rose-500">*</span>
            </label>
            <div class="mt-1">
                <input type="text"
                       name="patient_reference"
                       id="patient_reference"
                       value="{{ old('patient_reference', $case->patient_reference) }}"
                       required
                       placeholder="e.g. PAT-2001"
                       class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm font-mono @error('patient_reference') border-rose-300 ring-rose-300 @enderror">
            </div>
            <p class="mt-1 text-xs text-slate-400">Anonymized dummy patient identifier.</p>
            @error('patient_reference')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Surgeon Name -->
        <div>
            <label for="surgeon_name" class="block text-sm font-semibold text-slate-700">
                Surgeon Name <span class="text-rose-500">*</span>
            </label>
            <div class="mt-1">
                <input type="text"
                       name="surgeon_name"
                       id="surgeon_name"
                       value="{{ old('surgeon_name', $case->surgeon_name) }}"
                       required
                       placeholder="e.g. Dr. Robert Chen, MD"
                       class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('surgeon_name') border-rose-300 ring-rose-300 @enderror">
            </div>
            @error('surgeon_name')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Implant Type -->
        <div>
            <label for="implant_type" class="block text-sm font-semibold text-slate-700">
                Implant Type <span class="text-rose-500">*</span>
            </label>
            <div class="mt-1">
                <input type="text"
                       name="implant_type"
                       id="implant_type"
                       value="{{ old('implant_type', $case->implant_type) }}"
                       required
                       placeholder="e.g. Total Hip Replacement - Titanium Stem"
                       class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('implant_type') border-rose-300 ring-rose-300 @enderror">
            </div>
            @error('implant_type')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700">
                Status <span class="text-rose-500">*</span>
            </label>
            <div class="mt-1">
                <select name="status"
                        id="status"
                        required
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('status') border-rose-300 ring-rose-300 @enderror">
                    <option value="">Select a status...</option>
                    @foreach ($statuses as $status)
                        @php $val = $status->value; @endphp
                        <option value="{{ $val }}" {{ old('status', $case->status?->value ?? $case->status) === $val ? 'selected' : '' }}>
                            {{ $val }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('status')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Priority -->
        <div>
            <label for="priority" class="block text-sm font-semibold text-slate-700">
                Priority <span class="text-rose-500">*</span>
            </label>
            <div class="mt-1">
                <select name="priority"
                        id="priority"
                        required
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('priority') border-rose-300 ring-rose-300 @enderror">
                    <option value="">Select a priority...</option>
                    @foreach ($priorities as $priority)
                        @php $val = $priority->value; @endphp
                        <option value="{{ $val }}" {{ old('priority', $case->priority?->value ?? $case->priority) === $val ? 'selected' : '' }}>
                            {{ $val }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('priority')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Surgery Date -->
        <div class="md:col-span-2">
            <label for="surgery_date" class="block text-sm font-semibold text-slate-700">
                Surgery Date <span class="text-xs text-slate-400 font-normal">(Optional)</span>
            </label>
            <div class="mt-1 max-w-sm">
                <input type="date"
                       name="surgery_date"
                       id="surgery_date"
                       value="{{ old('surgery_date', $case->surgery_date ? $case->surgery_date->format('Y-m-d') : '') }}"
                       class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('surgery_date') border-rose-300 ring-rose-300 @enderror">
            </div>
            <p class="mt-1 text-xs text-slate-400">Scheduled operative date if finalized.</p>
            @error('surgery_date')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-6 border-t border-slate-200 flex items-center justify-end space-x-3">
        <a href="{{ $case->exists ? route('cases.show', $case) : route('cases.index') }}"
           class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition">
            Cancel
        </a>
        <button type="submit"
                class="px-5 py-2 rounded-lg text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 shadow-sm transition">
            {{ $case->exists ? 'Update Medical Case' : 'Create Medical Case' }}
        </button>
    </div>
</div>
