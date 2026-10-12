<?php

namespace App\Http\Requests;

use App\Enums\CasePriority;
use App\Enums\CaseStatus;
use App\Models\MedicalCase;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateCaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $case = $this->route('case') ?? $this->route('id');

        if (is_numeric($case)) {
            $case = MedicalCase::find($case);
        }

        return $this->user() && $case && $this->user()->can('update', $case);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $case = $this->route('case') ?? $this->route('id');
        $caseId = $case instanceof MedicalCase ? $case->id : $case;

        return [
            'case_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('cases', 'case_number')->ignore($caseId),
            ],
            'patient_reference' => ['required', 'string', 'max:100'],
            'surgeon_name' => ['required', 'string', 'max:150'],
            'implant_type' => ['required', 'string', 'max:150'],
            'status' => ['required', 'string', Rule::in(CaseStatus::values())],
            'priority' => ['required', 'string', Rule::in(CasePriority::values())],
            'surgery_date' => ['nullable', 'date'],
        ];
    }

    /**
     * Custom message formatting for API requests.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson() || $this->is('api/*')) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'data' => null,
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422));
        }

        parent::failedValidation($validator);
    }

    /**
     * Custom authorization failure formatting for API requests.
     */
    protected function failedAuthorization()
    {
        if ($this->expectsJson() || $this->is('api/*')) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'data' => null,
                'message' => 'This action is unauthorized.',
            ], 403));
        }

        parent::failedAuthorization();
    }
}
