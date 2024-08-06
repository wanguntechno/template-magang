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
        $breadcrumb = [
            ['link' => '/','name'=>'Dashboard'],
            ['link' => '/user','name'=>'User']
        ];

        return view('user.index', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'roles' => Role::listActiveRole(),
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(CreateUserRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name'=>'Dashboard'],
            ['link' => '/user','name'=>'User'],
            ['link' => '/user/create','name'=>'Create']
        ];

        return view('user.create', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'roles' => Role::listActiveRole(),
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'role_uuid' => $request->user_role_uuid,
                'username' => $request->user_username,
                'password' => $request->user_password,
                'password_confirmation' => $request->user_password_confirmation
            ];

            $user = app('StoreUser')->execute($input_dto, true);

            $alert = 'success';
            $message = 'User berhasil dibuat, password '. $input_dto['password'];
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  string  $uuid
    * @return \Illuminate\Http\Response
    */
    public function edit(EditUserRequest $request, $uuid)
    {
        $user = app('GetUser')->execute([
            'user_uuid' => $uuid
        ]);

        if (empty($user['data']))
        return view('errors.404');

        $breadcrumb = [
            ['link' => '/','name'=>'Dashboard'],
            ['link' => '/user','name'=>'User'],
            ['link' => "/user/$uuid/edit",'name'=>'Edit']
        ];

        return view('user.edit', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'roles' => Role::listActiveRole(),
            'user' => $user['data'],
        ]);
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
        DB::beginTransaction();
        try {
            $input_dto = [
                'user_uuid' => $user_uuid,
                'role_uuid' => $request->user_role_uuid,
                'username' => $request->user_username,
                'password' => $request->user_password,
                'password_confirmation' => $request->user_password_confirmation
            ];
            app('UpdateUser')->execute($input_dto,true);

            $alert = 'success';
            $message = 'User berhasil diupdate';
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  string  $uuid
    * @return \Illuminate\Http\Response
    */
    public function destroy(DeleteUserRequest $user_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'user_uuid' => $user_uuid
            ];

            app('DeleteUser')->execute($input_dto,true);
            DB::commit();

            $message = 'User berhasil dihapus';
            return response()->json([
                'success' => false,
                'message' => $message
            ],200);

        }catch (\Exception $ex) {
            DB::rollback();
            $message = $ex->getMessage();
            return response()->json([
                'success' => false,
                'message' => $message
            ],500);
        }
    }

    /**
    * Display a listing of the resource in datatable formats.
    *
    * @return \Illuminate\Http\Response
    */
    public function grid(GetUserRequest $request)
    {
        $request->merge([
            'per_page' => $request->length,
            'page' => $request->start/$request->length + 1,
            'with_pagination' => true,
            'search_param' => $request->search['value']
        ]);

        $user = app('GetUser')->execute($request->all());

        return datatables($user['data'])->skipPaging()
        ->with(["recordsTotal"    => $user['pagination']['total_data'],
        "recordsFiltered" => $user['pagination']['total_data'],
        ])
        ->rawColumns(['action','profile_picture'])
        ->addColumn('profile_picture', function ($row) {
            return (isset($row->pegawai->photo_id)) ?
            "<img src='".$row->pegawai->photo->generateUrl()->url."' width='100px' />"
            :
            "<img src='img/no_picture.png' width='100px' />";
        })
        ->addColumn('action', function ($row) {
            if (!in_array($row->userRole->role_id, [1])) {
                $action = [];
                (have_permission('user_edit')) ? array_push($action, "<a href='".route('user.edit', [$row->uuid])."' class='edit dropdown-item font-action'>Edit</a>") : null;
                (have_permission('user_delete')) ? array_push($action, "<button value='$row->uuid' class='delete dropdown-item font-action' >Delete</button>") : null;
                return generate_action_button($action);
            }
        })
        ->toJson();
    }
}
