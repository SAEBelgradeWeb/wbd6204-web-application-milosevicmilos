<?php

namespace App\Http\Controllers;

use App\Http\Requests\Floors\UpdateFloorRequest;
use App\Http\Requests\Floors\CreateFloorRequest;
use App\Models\User;
use App\Repositories\BuildingRepository;
use App\Repositories\FloorRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class FloorController extends Controller
{
    /**
     * @var FloorRepository
     */
    private $floorRepository;

    /**
     * FloorController constructor.
     * @param FloorRepository $floorRepository
     */
    public function __construct(FloorRepository $floorRepository)
    {
        $this->floorRepository = $floorRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'floors' => $this->getFloors($request->user())
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $floor = $this->floorRepository->get($id);

        if( ! $request->user()->can('manage', $floor)) {
            throw new HttpException(404, 'That floor doesn\'t exist.');
        }

        return response()->json([
            'floor' => $this->floorRepository->get($id)
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
        $floor = $this->floorRepository->get($id);

        if( ! $request->user()->can('manage', $floor)) {
            throw new HttpException(404, 'That floor doesn\'t exist.');
        }

        $this->floorRepository->delete($id);

        return response()->json([], 204);
    }

    /**
     * @param User $user
     * @return array
     */
    private function getFloors(User $user): array
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return $this->floorRepository
                ->getAll()
                ->toArray();
        }

        return $this->floorRepository
            ->getUserFloors($user->id)
            ->toArray();
    }
}
