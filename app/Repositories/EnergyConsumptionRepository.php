<?php

namespace App\Repositories;

use App\Models\EnergyConsumption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
     * @return float
     */
    public function totalConsumption(array $filters): float
    {
        $query = $this->model->select(
            DB::raw('SUM(consumption) AS consumption'),
        );

        $totalConsumption = $this->filterQuery($query, $filters)
                       ->first();

        if ($totalConsumption === null) {
            return 0;
        }

        return $this->kiloRoundUp($totalConsumption['consumption']);
    }

    /**
     * @param array $filters
     * @return Collection
     */
    public function consumptionPerYear(array $filters): Collection
    {
        $query = $this->model->select(
            DB::raw('SUM(consumption) AS consumption'),
            DB::raw('DATE_FORMAT(date, "%Y") as year'),
        );

        return $this->filterQuery($query, $filters)
                    ->groupBy('year')
                    ->orderBy('year', 'desc')
                    ->get();
    }

    /**
     * @param array $filters
     * @return Collection
     */
    public function consumptionPerMonth(array $filters): Collection
    {
        $query = $this->model->select(
            DB::raw('SUM(consumption) AS consumption'),
            DB::raw('DATE_FORMAT(date, "%M") as month'),
            DB::raw('DATE_FORMAT(date, "%y-%m") as order_date')
        );

        return $this->filterQuery($query, $filters)
                    ->groupBy('month', 'order_date')
                    ->orderBy('order_date', 'desc')
                    ->limit(12)
                    ->get();
    }

    /**
     * @param array $filters
     * @return Collection
     */
    public function consumptionPerWeek(array $filters): Collection
    {
        $query = $this->model->select(
            DB::raw('SUM(consumption) AS consumption'),
            DB::raw('DATE_FORMAT(date, "%W") as day'),
            DB::raw('DATE_FORMAT(date, "%y-%m-%d") as order_date')
        );

        return $this->filterQuery($query, $filters)
                    ->where('date', '>', now()->subDays(7))
                    ->groupBy('day', 'order_date')
                    ->orderBy('order_date', 'desc')
                    ->limit(7)
                    ->get();
    }

    /**
     * @param array $filters
     * @return Collection
     */
    public function consumptionPerBuilding(array $filters): Collection
    {
        $query = $this->model->select(
            'buildings.name as building_name',
            DB::raw('SUM(consumption) AS consumption'),
            DB::raw('DATE_FORMAT(date, "%M") as month'),
            DB::raw('DATE_FORMAT(date, "%y-%m") as order_date')
        );

        return $this->filterQuery($query, $filters)
            ->where('date', '>', now()->subMonths(11))

            ->groupBy('month', 'order_date', 'buildings.id')
                    ->orderBy('order_date', 'desc')
                    ->get();
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

        return $this->filterQuery($query, $filters)->first();
    }

    /**
     * @param array $filters
     * @return float
     */
    public function averageConsumptionPerYear(array $filters): float
    {
        return $this->calculateAverage($this->consumptionPerYear($filters));
    }

    /**
     * @param array $filters
     * @return float
     */
    public function averageConsumptionPerMonth(array $filters): float
    {
        return $this->calculateAverage($this->consumptionPerMonth($filters));
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

    /**
     * @param Collection $consumptions
     * @return float
     */
    private function calculateAverage(Collection $consumptions): float
    {
        $sum = 0;
        foreach ($consumptions as $consumption) {
            $sum += $consumption['consumption'];
        }

        return $this->kiloRoundUp($sum / count($consumptions));
    }

    /**
     * @param float $number
     * @return string
     */
    private function kiloRoundUp(float $number): string
    {
        return round($number /= 1000, 1);
    }
}