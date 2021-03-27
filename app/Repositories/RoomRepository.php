<?php

namespace App\Repositories;

use App\Models\Floor;
use Illuminate\Database\Eloquent\Collection;

final class RoomRepository extends Repository
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
    public function getRoomWithAppliances(): Collection
    {
        return $this->model::with('appliances')->get();
    }
}
