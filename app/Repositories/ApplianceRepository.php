<?php

namespace App\Repositories;

use App\Models\Appliance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class ApplianceRepository extends Repository
{
    /**
     * ApplianceRepository constructor.
     * @param Appliance $appliance
     */
    public function __construct(Appliance $appliance)
    {
        parent::__construct($appliance);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function get(int $id): Model
    {
        return $this->findOrFail($id)->load('applianceType');
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFilteredAppliances(array $filters)
    {
        $query = $this->model->select(
                'appliances.id',
                'appliances.name',
                'appliances.appliance_type_id',
                'appliances.room_id',
                'appliances.created_at')
            ->with('room.floor.building.user', 'applianceType')
            ->leftJoin('appliance_types', 'appliances.appliance_type_id', '=', 'appliance_types.id')
            ->leftJoin('rooms', 'appliances.room_id', '=', 'rooms.id')
            ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
            ->leftJoin('buildings', 'floors.building_id', '=', 'buildings.id')
            ->leftJoin('users', 'buildings.user_id', '=', 'users.id');

        if ($filters['user_id'] !== null) {
            $query->where('user_id', $filters['user_id']);
        }

        if ($filters['building_id'] !== null) {
            $query->where('building_id', $filters['building_id']);
        }

        if ($filters['floor_id'] !== null) {
            $query->where('floor_id', $filters['floor_id']);
        }

        if ($filters['room_id'] !== null) {
            $query->where('room_id', $filters['room_id']);
        }

        return $query->get();
    }
}