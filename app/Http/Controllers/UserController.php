<?php

namespace App\Http\Controllers;

use App\Helpers\Generate;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Libraries\Wablas;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(GetUserRequest $request)
    {
        
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(CreateUserRequest $request)
    {
        
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(StoreUserRequest $request)
    {
    
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  string  $uuid
    * @return \Illuminate\Http\Response
    */
    public function edit(EditUserRequest $request, $uuid)
    {
        
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  string  $uuid
    * @return \Illuminate\Http\Response
    */
    public function update(UpdateUserRequest $request, $user_uuid)
    {
        
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  string  $uuid
    * @return \Illuminate\Http\Response
    */
    public function destroy(DeleteUserRequest $user_uuid)
    {
        
    }

    /**
    * Display a listing of the resource in datatable formats.
    *
    * @return \Illuminate\Http\Response
    */
    public function grid(GetUserRequest $request)
    {
        
    }
}
