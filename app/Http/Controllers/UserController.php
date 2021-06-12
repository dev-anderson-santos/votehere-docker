<?php

namespace App\Http\Controllers;

use App\Http\Services\UserServices as ServicesUserServices;
use App\Models\RoleModel;
use App\Models\RoleUserModel;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userService;

    public function __construct(ServicesUserServices $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rolesPerUser = RoleUserModel::all()->filter(function($role) {
            return $role->role_id == RoleModel::CANDIDATO;
        })->toArray();

        return view('usuario.index', [
            'users' => User::paginate(10),
            'rolesPerUser' => $rolesPerUser
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->userService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('usuario.edit', ['candidato' => $this->userService->findById($id)]);
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
        return $this->userService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->userService->destroy($id);
    }

    public function eleitores()
    {
        return view('usuario.eleitores', ['eleitores' => RoleUserModel::eleitores(RoleModel::ELEITOR)->paginate(10)]);
    }

    public function killThemAll()
    {
        return $this->userService->killThemAll();
    }
}
