<?php

namespace App\Repositories;

use App\Models\Floor;
use Illuminate\Database\Eloquent\Collection;

final class FloorRepository extends Repository
{
    /**
     * FloorRepository constructor.
     * @param Floor $floor
     */
    public function __construct(Floor $floor)
    {
        parent::__construct($floor);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model::with(['building', 'rooms'])->get();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserFloors(int $userId): Collection
    {
        return $this->model->select(
            'floors.id',
            'building_id',
            'buildings.name AS building_name',
            'floors.name',
            'level',
            'floors.created_at',
            'floors.updated_at'
        )
                           ->with('rooms')
                           ->leftJoin('buildings', 'floors.building_id', '=', 'buildings.id')
                           ->where('buildings.user_id', $userId)
                           ->get();
    }
}
