<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

final class RegisteredUserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * RegisteredUserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming registration request.
     *
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $this->userRepository->create($request->all());

//        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME)->with('status', 'Message Sent!');
    }
}
