<?php

namespace App\Http\Controllers;

use App\Models\User;
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
