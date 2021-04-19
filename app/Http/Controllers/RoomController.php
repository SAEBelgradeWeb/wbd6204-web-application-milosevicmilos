<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\RoomRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Exception;

final class RoomController extends Controller
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * RoomController constructor.
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'rooms' => $this->getRooms($request->user())
        ]);
    }

    /**
     * @param User $user
     * @return array
     */
    private function getRooms(User $user): array
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return $this->roomRepository
                ->getAll()
                ->toArray();
        }

        return $this->roomRepository
            ->getUserRooms($user->id)
            ->toArray();
    }
}
