<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class UserRepository extends Repository
{
    public function __construct(User $userModel)
    {
        parent::__construct($userModel);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $data['password'] = bcrypt($data['password']);

        return parent::create($data);
    }
}
