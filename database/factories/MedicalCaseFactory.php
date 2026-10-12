<?php

namespace Database\Factories;

use App\Enums\CasePriority;
use App\Enums\CaseStatus;
use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalCase>
 */
class MedicalCaseFactory extends Factory
{
    protected $model = MedicalCase::class;

    protected static int $sequenceNumber = 1000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        self::$sequenceNumber++;

        $implantTypes = [
            'Total Hip Replacement - Titanium Stem',
            'Posterior Cervical Fusion Plate',
            'Anterior Lumbar Interbody Cage',
            'Bipolar Radial Head Prosthesis',
            'Dynamic Hip Screw System',
            'Cruciate Retaining Knee Prosthesis',
            'Pedicle Screw Spinal Fixation System',
            'Intramedullary Femoral Nail',
            'Anatomic Shoulder Hemiarthroplasty',
            'Tibial Plateau Reconstruction Plate',
        ];

        $surgeons = [
            'Dr. Robert Chen, MD',
            'Dr. Sarah Jenkins, MD',
            'Dr. Michael Vance, MD',
            'Dr. Elena Rostova, MD',
            'Dr. Jonathan Hayes, MD',
            'Dr. Priya Patel, MD',
            'Dr. Alexander Miller, MD',
            'Dr. Claire Dubois, MD',
        ];

        return [
            'case_number' => 'CASE-' . sprintf('%04d', self::$sequenceNumber),
            'patient_reference' => 'PAT-' . sprintf('%04d', fake()->numberBetween(1001, 9999)),
            'surgeon_name' => fake()->randomElement($surgeons),
            'implant_type' => fake()->randomElement($implantTypes),
            'status' => fake()->randomElement(CaseStatus::cases()),
            'priority' => fake()->randomElement(CasePriority::cases()),
            'surgery_date' => fake()->boolean(85) ? fake()->dateTimeBetween('now', '+60 days')->format('Y-m-d') : null,
            'created_by' => User::factory(),
        ];
    }
}
