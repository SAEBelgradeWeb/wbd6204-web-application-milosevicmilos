<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rooms\CreateRoomRequest;
use App\Http\Requests\Rooms\UpdateRoomRequest;
use App\Repositories\BuildingRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class BuildingFloorRoomController extends Controller
{
    /**
     * @var BuildingRepository
     */
    private $buildingRepository;

    /**
     * BuildingRepository constructor.
     * @param BuildingRepository $buildingRepository
     */
    public function __construct(BuildingRepository $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    /**
     * @param Request $request
     * @param int $buildingId
     * @param int $floorId
     * @return JsonResponse
     */
    public function index(Request $request, int $buildingId, int $floorId): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        return response()->json([
            'rooms' => $this->buildingRepository->getBuildingFloorRooms($buildingId, $floorId)
        ]);
    }

    /**
     * @param Request $request
     * @param int $buildingId
     * @param int $floorId
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $buildingId, int $floorId, int $id): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        return response()->json([
            'room' => $this->buildingRepository->getBuildingFloorRoom($buildingId, $floorId, $id)
        ]);
    }

    /**
     * @param CreateRoomRequest $request
     * @param int $buildingId
     * @param int $floorId
     * @return JsonResponse
     */
    public function store(CreateRoomRequest $request, int $buildingId, int $floorId): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        return response()->json([
            'room' => $this->buildingRepository->createBuildingFloorRoom($buildingId, $floorId, $request->all())
        ], 201);
    }

    /**
     * @param UpdateRoomRequest $request
     * @param int $buildingId
     * @param int $floorId
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRoomRequest $request, int $buildingId, int $floorId, int $id): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        return response()->json([
            'room' => $this->buildingRepository->updateBuildingFloorRoom($buildingId, $floorId, $id, $request->all())
        ]);
    }

    /**
     * @param Request $request
     * @param int $buildingId
     * @param int $floorId
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $buildingId, int $floorId, int $id): JsonResponse
    {
        $building = $this->buildingRepository->get($buildingId);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t exist.');
        }

        $this->buildingRepository->deleteBuildingFloorRoom($buildingId, $floorId, $id);

        return response()->json([], 204);
    }
}
