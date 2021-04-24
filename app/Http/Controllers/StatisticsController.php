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

    public function __construct(EnergyConsumptionRepository $energyConsumptionRepository)
    {
        $this->energyConsumptionRepository = $energyConsumptionRepository;
    }

    public function dashboard(FilterStatisticsRequest $request): JsonResponse
    {
        $data = [
            'average' => $this->energyConsumptionRepository->averageConsumption($request->all()),
            'averagePerHour' => $this->energyConsumptionRepository->averageConsumptionPerHour($request->all()),
            'averagePerDay' => $this->energyConsumptionRepository->averageConsumptionPerDay($request->all()),
            'averagePerMonth' => $this->energyConsumptionRepository->averageConsumptionPerMonth($request->all()),
            'averagePerYear' => $this->energyConsumptionRepository->averageConsumptionPerYear($request->all()),
        ];

        //- Daily consumption average.
        //- Monthly consumption average.
        //- Average hourly consumption (for all 24h).
        //- Average weekly consumption (for all 7 days).
        //- Devices that consume most of the electricity.
        //- Consumption difference with last month.
        //- Consumption goal (user settings).
        //- Number of (buildings, floors, rooms, devices).
        return response()->json($data);
    }

    public function appliance(): JsonResponse
    {

    }
}