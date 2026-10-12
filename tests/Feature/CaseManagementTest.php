<?php

namespace Tests\Feature;

use App\Enums\CasePriority;
use App\Enums\CaseStatus;
use App\Enums\UserRole;
use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CaseManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Build a valid payload for creating/updating a case.
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'case_number' => 'CASE-9001',
            'patient_reference' => 'PAT-9001',
            'surgeon_name' => 'Dr. Test Surgeon, MD',
            'implant_type' => 'Total Hip Replacement - Titanium Stem',
            'status' => CaseStatus::PLANNING->value,
            'priority' => CasePriority::HIGH->value,
            'surgery_date' => '2026-12-01',
        ], $overrides);
    }

    // ---------------------------------------------------------------------
    // Web: index, filters & authorization
    // ---------------------------------------------------------------------

    public function test_guests_cannot_access_case_registry(): void
    {
        $this->get(route('cases.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_view_case_registry(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('cases.index'))
            ->assertOk()
            ->assertSee('Medical Case Registry');
    }

    public function test_registry_can_be_filtered_by_status_and_priority(): void
    {
        $admin = User::factory()->admin()->create();

        MedicalCase::factory()->create([
            'created_by' => $admin->id,
            'case_number' => 'CASE-MATCH',
            'status' => CaseStatus::APPROVED,
            'priority' => CasePriority::HIGH,
        ]);

        MedicalCase::factory()->create([
            'created_by' => $admin->id,
            'case_number' => 'CASE-OTHER',
            'status' => CaseStatus::DRAFT,
            'priority' => CasePriority::LOW,
        ]);

        $response = $this->actingAs($admin)->get(route('cases.index', [
            'status' => CaseStatus::APPROVED->value,
            'priority' => CasePriority::HIGH->value,
        ]));

        $response->assertOk()
            ->assertSee('CASE-MATCH')
            ->assertDontSee('CASE-OTHER');
    }

    public function test_registry_can_be_searched_by_surgeon_name(): void
    {
        $admin = User::factory()->admin()->create();

        MedicalCase::factory()->create([
            'created_by' => $admin->id,
            'case_number' => 'CASE-SURGEON',
            'surgeon_name' => 'Dr. Unique Person, MD',
        ]);

        MedicalCase::factory()->create([
            'created_by' => $admin->id,
            'case_number' => 'CASE-OTHER',
            'surgeon_name' => 'Dr. Someone Else, MD',
        ]);

        $this->actingAs($admin)
            ->get(route('cases.index', ['surgeon_name' => 'Unique Person']))
            ->assertOk()
            ->assertSee('CASE-SURGEON')
            ->assertDontSee('CASE-OTHER');
    }

    // ---------------------------------------------------------------------
    // Web: create / update / delete (role based)
    // ---------------------------------------------------------------------

    public function test_admin_can_create_a_case(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->post(route('cases.store'), $this->payload());

        $response->assertRedirect();

        $this->assertDatabaseHas('cases', [
            'case_number' => 'CASE-9001',
            'created_by' => $admin->id,
        ]);
    }

    public function test_viewer_cannot_create_a_case(): void
    {
        $viewer = User::factory()->viewer()->create();

        $this->actingAs($viewer)
            ->post(route('cases.store'), $this->payload())
            ->assertForbidden();

        $this->assertDatabaseMissing('cases', ['case_number' => 'CASE-9001']);
    }

    public function test_admin_can_update_a_case(): void
    {
        $admin = User::factory()->admin()->create();
        $case = MedicalCase::factory()->create(['created_by' => $admin->id]);

        $this->actingAs($admin)
            ->put(route('cases.update', $case), $this->payload([
                'case_number' => $case->case_number,
                'status' => CaseStatus::COMPLETED->value,
            ]))
            ->assertRedirect(route('cases.show', $case));

        $this->assertSame(CaseStatus::COMPLETED, $case->fresh()->status);
    }

    public function test_admin_can_delete_a_case(): void
    {
        $admin = User::factory()->admin()->create();
        $case = MedicalCase::factory()->create(['created_by' => $admin->id]);

        $this->actingAs($admin)
            ->delete(route('cases.destroy', $case))
            ->assertRedirect(route('cases.index'));

        $this->assertDatabaseMissing('cases', ['id' => $case->id]);
    }

    public function test_viewer_cannot_delete_a_case(): void
    {
        $viewer = User::factory()->viewer()->create();
        $case = MedicalCase::factory()->create(['created_by' => $viewer->id]);

        $this->actingAs($viewer)
            ->delete(route('cases.destroy', $case))
            ->assertForbidden();

        $this->assertDatabaseHas('cases', ['id' => $case->id]);
    }

    public function test_case_creation_validates_required_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('cases.store'), [])
            ->assertSessionHasErrors([
                'case_number',
                'patient_reference',
                'surgeon_name',
                'implant_type',
                'status',
                'priority',
            ]);
    }

    public function test_case_number_must_be_unique(): void
    {
        $admin = User::factory()->admin()->create();
        MedicalCase::factory()->create([
            'created_by' => $admin->id,
            'case_number' => 'CASE-DUP',
        ]);

        $this->actingAs($admin)
            ->post(route('cases.store'), $this->payload(['case_number' => 'CASE-DUP']))
            ->assertSessionHasErrors('case_number');
    }

    // ---------------------------------------------------------------------
    // API
    // ---------------------------------------------------------------------

    public function test_api_requires_authentication(): void
    {
        $this->getJson('/api/cases')->assertUnauthorized();
    }

    public function test_api_returns_reference_options(): void
    {
        Sanctum::actingAs(User::factory()->viewer()->create());

        $this->getJson('/api/cases/options')
            ->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'statuses' => CaseStatus::values(),
                    'priorities' => CasePriority::values(),
                ],
            ]);
    }

    public function test_api_admin_can_create_and_list_cases(): void
    {
        Sanctum::actingAs($admin = User::factory()->admin()->create());

        $this->postJson('/api/cases', $this->payload())
            ->assertCreated()
            ->assertJsonPath('data.case_number', 'CASE-9001');

        $this->getJson('/api/cases')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.total', 1);
    }

    public function test_api_viewer_cannot_create_a_case(): void
    {
        Sanctum::actingAs(User::factory()->viewer()->create());

        $this->postJson('/api/cases', $this->payload())
            ->assertForbidden()
            ->assertJsonPath('success', false);
    }

    /**
     * Regression guard: API update must enforce the policy (previously missing).
     */
    public function test_api_viewer_cannot_update_a_case(): void
    {
        $viewer = User::factory()->viewer()->create();
        $case = MedicalCase::factory()->create(['created_by' => $viewer->id]);

        Sanctum::actingAs($viewer);

        $this->putJson("/api/cases/{$case->id}", $this->payload([
            'case_number' => $case->case_number,
            'status' => CaseStatus::COMPLETED->value,
        ]))->assertForbidden();

        $this->assertNotSame(CaseStatus::COMPLETED, $case->fresh()->status);
    }

    public function test_api_admin_can_update_a_case(): void
    {
        $admin = User::factory()->admin()->create();
        $case = MedicalCase::factory()->create(['created_by' => $admin->id]);

        Sanctum::actingAs($admin);

        $this->patchJson("/api/cases/{$case->id}", $this->payload([
            'case_number' => $case->case_number,
            'status' => CaseStatus::APPROVED->value,
        ]))
            ->assertOk()
            ->assertJsonPath('data.status', CaseStatus::APPROVED->value);

        $this->assertSame(CaseStatus::APPROVED, $case->fresh()->status);
    }

    public function test_api_returns_404_for_missing_case(): void
    {
        Sanctum::actingAs(User::factory()->admin()->create());

        $this->getJson('/api/cases/999999')
            ->assertNotFound()
            ->assertJsonPath('success', false);
    }

    public function test_api_current_user_endpoint_returns_profile(): void
    {
        $admin = User::factory()->admin()->create(['role' => UserRole::ADMIN]);
        Sanctum::actingAs($admin);

        $this->getJson('/api/user')
            ->assertOk()
            ->assertJsonPath('data.email', $admin->email)
            ->assertJsonPath('data.role', UserRole::ADMIN->value);
    }
}
