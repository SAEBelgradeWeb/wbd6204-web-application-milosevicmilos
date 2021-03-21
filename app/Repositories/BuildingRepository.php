<?php

namespace App\Repositories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

final class BuildingRepository extends Repository
{
    /**
     * BuildingRepository constructor.
     * @param Building $userModel
     */
    public function __construct(Building $userModel)
    {
        parent::__construct($userModel);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserBuildings(int $userId): Collection
    {
        return $this->model::where('user_id', $userId)->get();
    }
}
