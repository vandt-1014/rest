<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository;
use App\Eloquent\Objective;
use App\Exceptions\Api\UnknownException;
use App\User;
use Auth;
use DB;

class UserRepositoryEloquent extends AbstractRepositoryEloquent implements UserRepository
{
    public function model()
    {
        return app(User::class);
    }
    public function getAll()
    {
        return $this->select('id', 'name', 'email')->get();

    }

    public function show($id)
    {
        return $this->find($id);
    }

    public function store($data) {

        return $this->model()->create($data);
    }

    public function update($id, $data) {
        $user = $this->findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->findOrFail($id);
        $user->delete();

        return true;
    }
}
