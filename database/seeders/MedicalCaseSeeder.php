<?php

namespace Database\Seeders;

use App\Enums\CasePriority;
use App\Enums\CaseStatus;
use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Database\Seeder;

class MedicalCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@jajalmedical.com')->first();

        if (!$admin) {
            $admin = User::first();
        }

        $casesData = [
            [
                'case_number' => 'CASE-1001',
                'patient_reference' => 'PAT-2001',
                'surgeon_name' => 'Dr. Robert Chen, MD',
                'implant_type' => 'Total Hip Replacement - Titanium Stem',
                'status' => CaseStatus::APPROVED,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-10-20',
            ],
            [
                'case_number' => 'CASE-1002',
                'patient_reference' => 'PAT-2002',
                'surgeon_name' => 'Dr. Sarah Jenkins, MD',
                'implant_type' => 'Posterior Cervical Fusion Plate',
                'status' => CaseStatus::PLANNING,
                'priority' => CasePriority::MEDIUM,
                'surgery_date' => '2026-10-28',
            ],
            [
                'case_number' => 'CASE-1003',
                'patient_reference' => 'PAT-2003',
                'surgeon_name' => 'Dr. Michael Vance, MD',
                'implant_type' => 'Cruciate Retaining Knee Prosthesis',
                'status' => CaseStatus::COMPLETED,
                'priority' => CasePriority::MEDIUM,
                'surgery_date' => '2026-10-05',
            ],
            [
                'case_number' => 'CASE-1004',
                'patient_reference' => 'PAT-2004',
                'surgeon_name' => 'Dr. Jonathan Hayes, MD',
                'implant_type' => 'Anterior Lumbar Interbody Cage',
                'status' => CaseStatus::IN_REVIEW,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-11-02',
            ],
            [
                'case_number' => 'CASE-1005',
                'patient_reference' => 'PAT-2005',
                'surgeon_name' => 'Dr. Elena Rostova, MD',
                'implant_type' => 'Bipolar Radial Head Prosthesis',
                'status' => CaseStatus::DRAFT,
                'priority' => CasePriority::LOW,
                'surgery_date' => null,
            ],
            [
                'case_number' => 'CASE-1006',
                'patient_reference' => 'PAT-2006',
                'surgeon_name' => 'Dr. Robert Chen, MD',
                'implant_type' => 'Dynamic Hip Screw System',
                'status' => CaseStatus::PLANNING,
                'priority' => CasePriority::MEDIUM,
                'surgery_date' => '2026-11-15',
            ],
            [
                'case_number' => 'CASE-1007',
                'patient_reference' => 'PAT-2007',
                'surgeon_name' => 'Dr. Priya Patel, MD',
                'implant_type' => 'Pedicle Screw Spinal Fixation',
                'status' => CaseStatus::APPROVED,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-10-24',
            ],
            [
                'case_number' => 'CASE-1008',
                'patient_reference' => 'PAT-2008',
                'surgeon_name' => 'Dr. Alexander Miller, MD',
                'implant_type' => 'Intramedullary Femoral Nail',
                'status' => CaseStatus::COMPLETED,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-09-30',
            ],
            [
                'case_number' => 'CASE-1009',
                'patient_reference' => 'PAT-2009',
                'surgeon_name' => 'Dr. Sarah Jenkins, MD',
                'implant_type' => 'Anatomic Shoulder Hemiarthroplasty',
                'status' => CaseStatus::IN_REVIEW,
                'priority' => CasePriority::LOW,
                'surgery_date' => '2026-11-08',
            ],
            [
                'case_number' => 'CASE-1010',
                'patient_reference' => 'PAT-2010',
                'surgeon_name' => 'Dr. Michael Vance, MD',
                'implant_type' => 'Tibial Plateau Reconstruction Plate',
                'status' => CaseStatus::CANCELLED,
                'priority' => CasePriority::LOW,
                'surgery_date' => null,
            ],
            [
                'case_number' => 'CASE-1011',
                'patient_reference' => 'PAT-2011',
                'surgeon_name' => 'Dr. Claire Dubois, MD',
                'implant_type' => 'Total Hip Replacement - Ceramic Head',
                'status' => CaseStatus::APPROVED,
                'priority' => CasePriority::MEDIUM,
                'surgery_date' => '2026-10-29',
            ],
            [
                'case_number' => 'CASE-1012',
                'patient_reference' => 'PAT-2012',
                'surgeon_name' => 'Dr. Jonathan Hayes, MD',
                'implant_type' => 'Cervical Artificial Disc Replacement',
                'status' => CaseStatus::PLANNING,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-11-12',
            ],
            [
                'case_number' => 'CASE-1013',
                'patient_reference' => 'PAT-2013',
                'surgeon_name' => 'Dr. Elena Rostova, MD',
                'implant_type' => 'Distal Radius Volar Locking Plate',
                'status' => CaseStatus::COMPLETED,
                'priority' => CasePriority::MEDIUM,
                'surgery_date' => '2026-10-02',
            ],
            [
                'case_number' => 'CASE-1014',
                'patient_reference' => 'PAT-2014',
                'surgeon_name' => 'Dr. Robert Chen, MD',
                'implant_type' => 'Acetabular Revision Shell & Augment',
                'status' => CaseStatus::IN_REVIEW,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-11-05',
            ],
            [
                'case_number' => 'CASE-1015',
                'patient_reference' => 'PAT-2015',
                'surgeon_name' => 'Dr. Priya Patel, MD',
                'implant_type' => 'Thoracolumbar Deformity Correction Rods',
                'status' => CaseStatus::APPROVED,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-10-22',
            ],
            [
                'case_number' => 'CASE-1016',
                'patient_reference' => 'PAT-2016',
                'surgeon_name' => 'Dr. Alexander Miller, MD',
                'implant_type' => 'Unicompartmental Knee Replacement',
                'status' => CaseStatus::DRAFT,
                'priority' => CasePriority::LOW,
                'surgery_date' => null,
            ],
            [
                'case_number' => 'CASE-1017',
                'patient_reference' => 'PAT-2017',
                'surgeon_name' => 'Dr. Sarah Jenkins, MD',
                'implant_type' => 'Occipito-Cervical Fixation Construct',
                'status' => CaseStatus::PLANNING,
                'priority' => CasePriority::MEDIUM,
                'surgery_date' => '2026-11-18',
            ],
            [
                'case_number' => 'CASE-1018',
                'patient_reference' => 'PAT-2018',
                'surgeon_name' => 'Dr. Claire Dubois, MD',
                'implant_type' => 'Reverse Total Shoulder Arthroplasty',
                'status' => CaseStatus::APPROVED,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-10-27',
            ],
            [
                'case_number' => 'CASE-1019',
                'patient_reference' => 'PAT-2019',
                'surgeon_name' => 'Dr. Jonathan Hayes, MD',
                'implant_type' => 'Lumbar Microdiscectomy Annular Closure',
                'status' => CaseStatus::COMPLETED,
                'priority' => CasePriority::LOW,
                'surgery_date' => '2026-09-25',
            ],
            [
                'case_number' => 'CASE-1020',
                'patient_reference' => 'PAT-2020',
                'surgeon_name' => 'Dr. Elena Rostova, MD',
                'implant_type' => 'Clavicle Superior Reconstruction Plate',
                'status' => CaseStatus::IN_REVIEW,
                'priority' => CasePriority::MEDIUM,
                'surgery_date' => '2026-11-09',
            ],
            [
                'case_number' => 'CASE-1021',
                'patient_reference' => 'PAT-2021',
                'surgeon_name' => 'Dr. Michael Vance, MD',
                'implant_type' => 'Tibial Diaphyseal Interlocking Nail',
                'status' => CaseStatus::CANCELLED,
                'priority' => CasePriority::LOW,
                'surgery_date' => null,
            ],
            [
                'case_number' => 'CASE-1022',
                'patient_reference' => 'PAT-2022',
                'surgeon_name' => 'Dr. Priya Patel, MD',
                'implant_type' => 'Scoliosis Spinal Fusion Implant System',
                'status' => CaseStatus::PLANNING,
                'priority' => CasePriority::HIGH,
                'surgery_date' => '2026-11-25',
            ],
        ];

        foreach ($casesData as $item) {
            MedicalCase::updateOrCreate(
                ['case_number' => $item['case_number']],
                array_merge($item, ['created_by' => $admin->id])
            );
        }
    }
}
