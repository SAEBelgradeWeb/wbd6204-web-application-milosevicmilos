<?php

namespace App\Http\Controllers;

use App\Http\Requests\Statistics\FilterStatisticsRequest;
use App\Repositories\EnergyConsumptionRepository;
use Illuminate\Http\JsonResponse;

final class StatisticsController extends Controller
{
    /**
     * @var EnergyConsumptionRepository
     */
    private $energyConsumptionRepository;

    /**
     * StatisticsController constructor.
     * @param EnergyConsumptionRepository $energyConsumptionRepository
     */
    public function __construct(EnergyConsumptionRepository $energyConsumptionRepository)
    {
        $this->energyConsumptionRepository = $energyConsumptionRepository;
    }

    /**
     * @param FilterStatisticsRequest $request
     * @return JsonResponse
     */
    public function consumptionStatistics(FilterStatisticsRequest $request): JsonResponse
    {
        return response()->json([
            'totalConsumption' => $this->energyConsumptionRepository->totalConsumption($request->all()),
            'averageConsumptionPerYear' => $this->energyConsumptionRepository->averageConsumptionPerYear($request->all()),
            'averageConsumptionPerMonth' => $this->energyConsumptionRepository->averageConsumptionPerMonth($request->all()),
        ]);
    }

    /**
     * @param FilterStatisticsRequest $request
     * @return JsonResponse
     */
    public function consumptionPerMonth(FilterStatisticsRequest $request): JsonResponse
    {
        $data = [
            'data' => [],
            'labels' => []
        ];

        foreach ($this->energyConsumptionRepository->consumptionPerMonth($request->all())->reverse() as $month) {
            $data['data'][] = $this->kiloRoundUp($month['consumption']);
            $data['labels'][] = $month['month'];
        }

        return response()->json($data);
    }

    /**
     * @param FilterStatisticsRequest $request
     * @return JsonResponse
     */
    public function consumptionPerWeek(FilterStatisticsRequest $request): JsonResponse
    {
        $data = [
            'data' => [],
            'labels' => []
        ];

        foreach ($this->energyConsumptionRepository->consumptionPerWeek($request->all()) as $day) {
            $data['data'][] = $this->kiloRoundUp($day['consumption']);
            $data['labels'][] = $day['day'];
        }

        return response()->json($data);
    }

    /**
     * @param FilterStatisticsRequest $request
     * @return JsonResponse
     */
    public function consumptionPerBuilding(FilterStatisticsRequest $request): JsonResponse
    {
        $data = [
            'labels' => [],
            'building' => []
        ];

        foreach ($this->energyConsumptionRepository->consumptionPerBuilding($request->all())->reverse() as $building) {
            if ( ! in_array($building['month'], $data['labels'], true)) {
                $data['labels'][] = $building['month'];
            }

            $data['building'][$building['building_name']][] = $this->kiloRoundUp($building['consumption']);
        }

        return response()->json($data);
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