<?php

namespace App\Policies;

use App\Models\MedicalCase;
use App\Models\User;

class CasePolicy
{
    /**
     * Determine whether the user can view any cases.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isViewer();
    }

    /**
     * Determine whether the user can view the specific case.
     */
    public function view(User $user, MedicalCase $medicalCase): bool
    {
        return $user->isAdmin() || $user->isViewer();
    }

    /**
     * Determine whether the user can create cases.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the case.
     */
    public function update(User $user, MedicalCase $medicalCase): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the case.
     */
    public function delete(User $user, MedicalCase $medicalCase): bool
    {
        return $user->isAdmin();
    }
}
