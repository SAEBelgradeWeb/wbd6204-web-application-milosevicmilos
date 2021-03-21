<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws HttpException
     */
    public function index(Request $request): JsonResponse
    {
        if( ! $request->user()->can('manage', User::class)) {
            throw new HttpException(403, 'You don\'t have access to this endpoint.');
        }

        $data['users'] = $this->userRepository
            ->getAll()
            ->toArray();

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        if( ! $request->user()->can('manage', User::class)) {
            throw new HttpException(403, 'You don\'t have access to this endpoint.');
        }

        $user = $this->userRepository->get($id);

        return response()->json(['user' => $user]);
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request->all());

        return response()->json(['user' => $user], 201);
    }

    /**
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = $this->userRepository->update($id, $request->all());

        return response()->json(['user' => $user]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        if( ! $request->user()->can('manage', User::class)) {
            throw new HttpException(403, 'You don\'t have access to this endpoint.');
        }

        $this->userRepository->delete($id);

        return response()->json([], 204);
    }
}
