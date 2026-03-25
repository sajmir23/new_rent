<?php

namespace App\Models\Traits;

trait HasCompanyOwnership
{
    public function isOwnedByCompany($companyId): bool
    {
        return $this->company_id === $companyId;
    }
}
