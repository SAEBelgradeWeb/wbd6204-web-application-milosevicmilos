<?php

namespace App\Repositories;

use App\Models\Room;

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
}
