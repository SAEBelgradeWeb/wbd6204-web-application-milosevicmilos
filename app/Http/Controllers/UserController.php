<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;

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
     * Display a listing of users.
     *
     * @param Request $request
     * @return View
     */
    public function index(): View
    {
//        $request->user()->can('manage', User::class);

//        $tableHelper = new AdminTablesHelper();

//        $data['table'] = $tableHelper->usersTable();
        $data['users'] = $this->userRepository
            ->getAllUsers()
            ->toArray();

        die(json_encode($data));
//        return view('admin.users.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $request->user()->can('manage', User::class);

        $data = $this->dataForCreateEditUser();

        die(json_encode($data));

//        return view('admin.users.create', compact('access_levels', 'user_access_options', 'skill_options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return RedirectResponse
     */
    public function store(CreateUserRequest $request): RedirectResponse
    {
        $request->user()->can('manage', User::class);

        $user = $this->userRepository->createUser($request->all());

        die($user);
//        return redirect()->route('users.edit')
//            ->with('alert', ['type'=>'success', 'message' => 'User successfully created.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param Request $request
     * @return View
     */
    public function edit(Request $request, int $id): View
    {
        $request->user()->can('manage', User::class);

        $data['user'] = $this->userRepository->findOrFail($id)->toArray();
        $data = array_merge($data, $this->dataForCreateEditUser());

        die(json_encode($data));
    }

    /**
     * @param UpdateUserRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $request->user()->can('manage', User::class);

        $user = $this->userRepository->updateUser($id, $request->all());

        die($user);

//        return redirect()->route('users.edit')
//            ->with('alert', ['type'=>'success', 'message' => 'User successfully edited.']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $request->user()->can('manage', User::class);

        $this->userRepository->deleteUser($id);

        die();

//        return redirect()->route('users.index')
//            ->with('alert', ['type'=>'success', 'message'=>'User successfully removed.']);
    }

    /**
     * Prepare data for create/edit user forms.
     *
     * @return array
     */
    private function dataForCreateEditUser(): array
    {
        $data['roles'] = $this->roleRepository
            ->getAllRoles();

        $data['groups'] = $this->groupRepository
            ->getAllGroups()
            ->pluck('name', 'id')
            ->toArray();

        $data['skills'] = $this->skillRepository
            ->getAllSkills()
            ->pluck('name', 'id')
            ->toArray();

        return $data;
    }
}
