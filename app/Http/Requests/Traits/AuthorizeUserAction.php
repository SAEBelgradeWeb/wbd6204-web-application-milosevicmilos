<?php

namespace App\Http\Requests\Traits;

use App\Repositories\BuildingRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait AuthorizeUserAction
{
    /**
     * @param BuildingRepository $buildingRepository
     * @param int $buildingId
     * @return bool
     */
    public function authorizeUserAction(BuildingRepository $buildingRepository, int $buildingId): bool
    {
        $building = $buildingRepository->get($buildingId);

        if( ! $this->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t have exist.');
        }

        return true;
    }
}