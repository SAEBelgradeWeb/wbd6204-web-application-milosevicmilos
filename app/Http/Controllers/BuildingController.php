<?php

namespace App\Http\Controllers;

use App\Http\Requests\Buildings\CreateBuildingRequest;
use App\Http\Requests\Buildings\UpdateBuildingRequest;
use App\Models\User;
use App\Repositories\BuildingRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class BuildingController extends Controller
{
    /**
     * @var BuildingRepository
     */
    private $buildingRepository;

    /**
     * BuildingController constructor.
     * @param BuildingRepository $buildingRepository
     */
    public function __construct(BuildingRepository $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'buildings' => $this->getBuildings($request->user())
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $building = $this->buildingRepository->get($id);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t have exist.');
        }

        return response()->json(['building' => $building]);
    }

    /**
     * @param CreateBuildingRequest $request
     * @return JsonResponse
     */
    public function store(CreateBuildingRequest $request): JsonResponse
    {
        return response()->json([
            'building' => $this->buildingRepository->create($request->all())
        ], 201);
    }

    /**
     * @param UpdateBuildingRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws HttpException
     */
    public function update(UpdateBuildingRequest $request, int $id): JsonResponse
    {
        return response()->json([
            'building' => $this->buildingRepository->update($id, $request->all())
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws HttpException
     * @throws Exception
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $building = $this->buildingRepository->get($id);

        if( ! $request->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t have exist.');
        }

        $this->buildingRepository->delete($id);

        return response()->json([], 204);
    }

    /**
     * @param User $user
     * @return array
     */
    private function getBuildings(User $user): array
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return $this->buildingRepository
                ->getAll()
                ->toArray();
        }

        return $this->buildingRepository
            ->getUserBuildings($user->id)
            ->toArray();
    }
}
