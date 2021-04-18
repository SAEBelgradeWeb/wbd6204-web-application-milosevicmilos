<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

final class RoomRepository extends Repository
{
    /**
     * RoomRepository constructor.
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model::with(['floor'])->get();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserRooms(int $userId): Collection
    {
        return $this->model->select(
            'rooms.id',
            'floor_id',
            'floors.name AS floor_name',
            'rooms.name',
            'size',
            'rooms.created_at',
            'rooms.updated_at'
        )
                            ->with('floor')
                            ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
                            ->leftJoin('buildings', 'floors.building_id', '=', 'buildings.id')
                            ->where('buildings.user_id', $userId)
                            ->get();
    }
}
