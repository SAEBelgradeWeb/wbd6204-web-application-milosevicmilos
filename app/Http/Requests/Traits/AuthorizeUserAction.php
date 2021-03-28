<?php

namespace App\Http\Requests\Traits;

use App\Repositories\BuildingRepository;
use App\Repositories\RoomRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait AuthorizeUserAction
{
    /**
     * @param BuildingRepository $buildingRepository
     * @param int $buildingId
     * @return bool
     */
    public function authorizeBuildingManagement(BuildingRepository $buildingRepository, int $buildingId): bool
    {
        $building = $buildingRepository->get($buildingId);

        if( ! $this->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t have exist.');
        }

        return true;
    }

    /**
     * @param RoomRepository $roomRepository
     * @param int $roomId
     * @return bool
     */
    public function authorizeRoomManagement(RoomRepository $roomRepository, int $roomId): bool
    {
        $room = $roomRepository->get($roomId);

        if( ! $this->user()->can('manage', $room)) {
            throw new HttpException(404, 'That room doesn\'t have exist.');
        }

        return true;
    }
}