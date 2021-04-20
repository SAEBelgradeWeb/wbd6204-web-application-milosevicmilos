<?php

namespace App\Repositories;

use App\Models\ApplianceType;

final class ApplianceTypeRepository extends Repository
{
    /**
     * ApplianceTypeRepository constructor.
     * @param ApplianceType $applianceType
     */
    public function __construct(ApplianceType $applianceType)
    {
        parent::__construct($applianceType);
    }
}