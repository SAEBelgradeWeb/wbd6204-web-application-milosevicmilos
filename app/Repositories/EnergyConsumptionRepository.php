<?php

namespace App\Repositories;

use App\Models\EnergyConsumption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class EnergyConsumptionRepository extends Repository
{
    /**
     * EnergyConsumptionRepository constructor.
     * @param EnergyConsumption $energyConsumption
     */
    public function __construct(EnergyConsumption $energyConsumption)
    {
        parent::__construct($energyConsumption);
    }

    /**
     * @param array $filters
     * @return Model
     */
    public function averageConsumption(array $filters): Model
    {
        $query = $this->model->select(
            DB::raw('AVG(consumption) AS average_consumption')
        );

        $query = $this->filterQuery($query, $filters);

        return $query->first();
    }

    public function averageConsumptionPerYear(array $filters)
    {
        $query = $this->model->select(
            DB::raw('AVG(consumption) AS average_consumption'),
            DB::raw('DATE_FORMAT(date, "%Y") as year')
        );

        return $this->filterQuery($query, $filters)
                    ->groupBy('year')
                    ->first();
    }

    public function averageConsumptionPerMonth(array $filters)
    {
        $query = $this->model->select(
            DB::raw('AVG(consumption) AS average_consumption'),
            DB::raw('DATE_FORMAT(date, "%Y-%m") as month')
        );

        return $this->filterQuery($query, $filters)
                    ->groupBy('month')
                    ->first();
    }

    public function averageConsumptionPerDay(array $filters)
    {
        $query = $this->model->select(
            DB::raw('AVG(consumption) AS average_consumption'),
            DB::raw('DATE_FORMAT(date, "%Y-%m-%d") as day')
        );

        return $this->filterQuery($query, $filters)
                    ->groupBy('day')
                    ->first();
    }

    public function averageConsumptionPerHour(array $filters)
    {
        $query = $this->model->select(
            DB::raw('AVG(consumption) AS average_consumption'),
        );

        return $this->filterQuery($query, $filters)
                    ->first();
    }

    /**
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    private function filterQuery(Builder $query, array $filters): Builder
    {
        $query->leftJoin('appliances', 'energy_consumptions.appliance_id', '=', 'appliances.id')
              ->leftJoin('appliance_types', 'appliances.appliance_type_id', '=', 'appliance_types.id')
              ->leftJoin('rooms', 'appliances.room_id', '=', 'rooms.id')
              ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
              ->leftJoin('buildings', 'floors.building_id', '=', 'buildings.id')
              ->leftJoin('users', 'buildings.user_id', '=', 'users.id')
              ->where('date', '<=', now());


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

        if ($filters['appliance_id'] !== null) {
            $query->where('appliance_id', $filters['appliance_id']);
        }

        return $query;
    }
}