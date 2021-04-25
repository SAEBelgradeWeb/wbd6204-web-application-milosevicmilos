<?php

namespace App\Http\Controllers;

use App\Http\Requests\Statistics\FilterStatisticsRequest;
use App\Repositories\EnergyConsumptionRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

final class StatisticsController extends Controller
{
    /**
     * @var EnergyConsumptionRepository
     */
    private $energyConsumptionRepository;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * StatisticsController constructor.
     * @param EnergyConsumptionRepository $energyConsumptionRepository
     * @throws BindingResolutionException
     */
    public function __construct(EnergyConsumptionRepository $energyConsumptionRepository)
    {
        $this->energyConsumptionRepository = $energyConsumptionRepository;
        $this->cache = app()->make('cache');
        $this->auth = app()->make('auth');
    }

    /**
     * @param FilterStatisticsRequest $request
     * @return JsonResponse
     */
    public function consumptionStatistics(FilterStatisticsRequest $request): JsonResponse
    {
        $cacheKey = 'consumption-statistics-' . $this->auth->user()->id;
        if ($data = $this->cache->get($cacheKey)) {
            return response()->json($data);
        }

        $data = [
            'totalConsumption' => $this->energyConsumptionRepository->totalConsumption($request->all()),
            'averageConsumptionPerYear' => $this->energyConsumptionRepository->averageConsumptionPerYear($request->all()),
            'averageConsumptionPerMonth' => $this->energyConsumptionRepository->averageConsumptionPerMonth($request->all()),
        ];

        $this->cache->put($cacheKey, $data, 600);

        return response()->json($data);
    }

    /**
     * @param FilterStatisticsRequest $request
     * @return JsonResponse
     */
    public function consumptionPerMonth(FilterStatisticsRequest $request): JsonResponse
    {
        $cacheKey = 'consumption-per-month-' . $this->auth->user()->id;
        if ($data = $this->cache->get($cacheKey)) {
            return response()->json($data);
        }

        $data = [
            'data' => [],
            'labels' => []
        ];

        foreach ($this->energyConsumptionRepository->consumptionPerMonth($request->all())->reverse() as $month) {
            $data['data'][] = $this->kiloRoundUp($month['consumption']);
            $data['labels'][] = $month['month'];
        }

        $this->cache->put($cacheKey, $data, 600);

        return response()->json($data);
    }

    /**
     * @param FilterStatisticsRequest $request
     * @return JsonResponse
     */
    public function consumptionPerWeek(FilterStatisticsRequest $request): JsonResponse
    {
        $cacheKey = 'consumption-per-week-' . $this->auth->user()->id;
        if ($data = $this->cache->get($cacheKey)) {
            return response()->json($data);
        }

        $data = [
            'data' => [],
            'labels' => []
        ];

        foreach ($this->energyConsumptionRepository->consumptionPerWeek($request->all()) as $day) {
            $data['data'][] = $this->kiloRoundUp($day['consumption']);
            $data['labels'][] = $day['day'];
        }

        $this->cache->put($cacheKey, $data, 600);

        return response()->json($data);
    }

    /**
     * @param FilterStatisticsRequest $request
     * @return JsonResponse
     */
    public function consumptionPerBuilding(FilterStatisticsRequest $request): JsonResponse
    {
        $cacheKey = 'consumption-per-building-' . $this->auth->user()->id;
        if ($data = $this->cache->get($cacheKey)) {
            return response()->json($data);
        }

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

        $this->cache->put($cacheKey, $data, 600);

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