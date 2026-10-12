<?php

namespace App\Models;

use App\Enums\CasePriority;
use App\Enums\CaseStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalCase extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'case_number',
        'patient_reference',
        'surgeon_name',
        'implant_type',
        'status',
        'priority',
        'surgery_date',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => CaseStatus::class,
        'priority' => CasePriority::class,
        'surgery_date' => 'date',
    ];

    /**
     * Get the user who created this medical case.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to search by case number and/or surgeon name.
     */
    public function scopeSearch(Builder $query, ?string $caseNumber = null, ?string $surgeonName = null): Builder
    {
        if (!empty($caseNumber)) {
            $query->where('case_number', 'like', '%' . trim($caseNumber) . '%');
        }

        if (!empty($surgeonName)) {
            $query->where('surgeon_name', 'like', '%' . trim($surgeonName) . '%');
        }

        return $query;
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeFilterStatus(Builder $query, ?string $status = null): Builder
    {
        if (!empty($status)) {
            $query->where('status', trim($status));
        }

        return $query;
    }
}
