<?php

namespace App\Http\Controllers;

use App\Http\Requests\Floors\UpdateFloorRequest;
use App\Http\Requests\Floors\CreateFloorRequest;
use App\Repositories\BuildingRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class BuildingFloorController extends Controller
{
    /**
     * @var BuildingRepository
     */
    private $buildingRepository;

    /**
     * BuildingFloorController constructor.
     * @param BuildingRepository $buildingRepository
     */
    public function __construct(BuildingRepository $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    /**
     * @param Request $request
     * @param int $buildingId
     * @return JsonResponse
     */
    public function index(Request $request, int $buildingId): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        return response()->json([
            'floors' => $this->buildingRepository->getAllBuildingFloors($buildingId)
        ]);
    }

    /**
     * @param Request $request
     * @param int $buildingId
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $buildingId, int $id): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        return response()->json([
            'floor' => $this->buildingRepository->getBuildingFloor($buildingId, $id)
        ]);
    }

    /**
     * @param CreateFloorRequest $request
     * @param int $buildingId
     * @return JsonResponse
     */
    public function store(CreateFloorRequest $request, int $buildingId): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        return response()->json([
            'floor' => $this->buildingRepository->createBuildingFloor($buildingId, $request->all())
        ], 201);
    }

    /**
     * @param UpdateFloorRequest $request
     * @param int $buildingId
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateFloorRequest $request, int $buildingId, int $id): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t have exist.');
        }

        return response()->json([
            'floor' => $this->buildingRepository->updateBuildingFloor($buildingId, $id, $request->all())
        ]);
    }

    /**
     * @param Request $request
     * @param int $buildingId
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $buildingId, int $id): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        $this->buildingRepository->deleteBuildingFloor($buildingId, $id);

        return response()->json([], 204);
    }
}
