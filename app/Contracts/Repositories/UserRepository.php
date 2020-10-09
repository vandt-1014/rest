<?php

namespace App\Contracts\Repositories;

use App\User;

interface UserRepository extends AbstractRepository
{
    public function getAll();

    public function show($id);

    public function update($id, $data);

    public function delete($id);

}
