<?php

namespace App\Repositories;

use App\Models\Building;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class BuildingRepository extends Repository
{
    /**
     * BuildingRepository constructor.
     * @param Building $building
     */
    public function __construct(Building $building)
    {
        parent::__construct($building);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model::with(['floors.rooms', 'user'])->get();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserBuildings(int $userId): Collection
    {
        return $this->model::with('floors.rooms')->where('user_id', $userId)->get();
    }

    /**
     * @param int $buildingId
     * @return Collection
     */
    public function getAllBuildingFloors(int $buildingId): Collection
    {
        return $this->findOrFail($buildingId)->floors()->with('rooms')->get();
    }

    /**
     * @param int $buildingId
     * @param int $id
     * @return Model
     */
    public function getBuildingFloor(int $buildingId, int $id): Model
    {
        return $this->model->findOrFail($buildingId)->floors()->findOrFail($id)->load('rooms');
    }

    /**
     * @param int $buildingId
     * @param array $data
     * @return Model
     */
    public function createBuildingFloor(int $buildingId, array $data): Model
    {
        return $this->findOrFail($buildingId)->floors()->create($data);
    }

    /**
     * @param int $buildingId
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function updateBuildingFloor(int $buildingId, int $id, array $data): Model
    {
        $floor = $this->getBuildingFloor($buildingId, $id);
        $floor->update($data);
        $floor->save();

        return $floor;
    }

    /**
     * @param int $buildingId
     * @param int $id
     * @throws Exception
     */
    public function deleteBuildingFloor(int $buildingId, int $id): void
    {
        $this->getBuildingFloor($buildingId, $id)->delete();
    }

    /**
     * @param int $buildingId
     * @param int $floorId
     * @return Collection
     */
    public function getBuildingFloorRooms(int $buildingId, int $floorId): Collection
    {
        return $this->getBuildingFloor($buildingId, $floorId)->rooms()->get();
    }

    /**
     * @param int $buildingId
     * @param int $floorId
     * @param int $id
     * @return Model
     */
    public function getBuildingFloorRoom(int $buildingId, int $floorId, int $id): Model
    {
        return $this->getBuildingFloor($buildingId, $floorId)->rooms()->findOrFail($id);
    }

    /**
     * @param $buildingId
     * @param $floorId
     * @param $data
     * @return Model
     */
    public function createBuildingFloorRoom($buildingId, $floorId, $data): Model
    {
        return $this->getBuildingFloor($buildingId, $floorId)->rooms()->create($data);
    }

    /**
     * @param $buildingId
     * @param $floorId
     * @param $roomId
     * @param $data
     * @return Model
     */
    public function updateBuildingFloorRoom($buildingId, $floorId, $roomId, $data): Model
    {
        $room = $this->getBuildingFloorRoom($buildingId, $floorId, $roomId);
        $room->update($data);
        $room->save();

        return $room;
    }

    /**
     * @param int $buildingId
     * @param int $floorId
     * @param int $id
     * @throws Exception
     */
    public function deleteBuildingFloorRoom(int $buildingId, int $floorId, int $id): void
    {
        $this->getBuildingFloorRoom($buildingId, $floorId, $id)->delete();
    }
}
