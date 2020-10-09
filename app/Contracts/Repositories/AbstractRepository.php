<?php

namespace App\Contracts\Repositories;

interface AbstractRepository
{
    public function getAll();

    public function model();

    public function store($data);
//    public function getById($id);
//
//    public function create($attribute = []);
//
//    public function update($id, $attribute = []);
//
//    public function delete($id);

}
