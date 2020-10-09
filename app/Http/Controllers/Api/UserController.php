<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends ApiController
{ protected  $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->userRepository->getAll();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(
            'name',
            'email',
            'password'
        );

        return $this->doAction(function () use ($data) {
            $this->compacts['data'] = $this->userRepository->store($data);
            $this->compacts['description'] = 'success.create';
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->getData(function () use ($id) {
            $this->compacts['data'] = $this->userRepository->show($id);
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(
            'name',
            'email',
            'password'
        );

        return $this->doAction(function () use ($id, $data) {
            $this->compacts['data'] = $this->userRepository->update($id, $data);
            $this->compacts['description'] = 'success.update';
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->doAction(function () use ($id) {
            $this->compacts['data'] = $this->userRepository->delete($id);
            $this->compacts['description'] = ($this->compacts['data'])
                ? 'success.delete'
                : 'cannotDeleteUser';
        });
    }
}
