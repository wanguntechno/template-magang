<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\EditRoleRequest;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\DeleteRoleRequest;
use App\Http\Requests\Role\GetRoleRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(GetRoleRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name'=>'Dashboard'],
            ['link' => '/user','name'=>'Role']
        ];
        return view('role.index', [
            'breadcrumb' => breadcrumb($breadcrumb)
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(CreateRoleRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name'=>'Dashboard'],
            ['link' => '/role','name'=>'Role'],
            ['link' => '/role/create','name'=>'Create']
        ];
        return view('role.create', [
            'breadcrumb' => breadcrumb($breadcrumb),
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(StoreRoleRequest $request)
    {
        $result = app('StoreRole')->execute([
            'name' => $request->role_name,
            'code' => $request->role_code,
            'description' => $request->role_description
        ]);
        $alert = (isset($result['error'])) ? 'danger' : 'success';
        if ($result['error'] != null) {
            if ($result['response_code'] == 422) {
                $error = \Illuminate\Validation\ValidationException::withMessages(collect($result['message'])->toArray());
                throw $error;
            } else {
                return redirect()->back()->withInput()->with( $alert , $result['message'] );
            }
        }
        return redirect()->back()->with( $alert ,$result['message'] );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(EditRoleRequest $request, $role_uuid)
    {
        $role = app('GetRole')->execute([
            'role_uuid' => $role_uuid
        ]);

        if (empty($role['data']))
        return view('errors.404');

        $breadcrumb = [
            ['link' => '/','name'=>'Dashboard'],
            ['link' => '/role','name'=>'Role'],
            ['link' => '/role/edit','name'=>'Edit']
        ];
        return view('role.edit', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'role' => $role['data']
        ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(UpdateRoleRequest $request, $role_uuid)
    {
        $result = app('UpdateRole')->execute([
            'role_uuid' => $role_uuid,
            'name' => $request->role_name,
            'code' => $request->role_code,
            'description' => $request->role_description
        ]);

        $alert = (isset($result['error'])) ? 'danger' : 'success';
        if ($result['error'] != null) {
            if ($result['response_code'] == 422) {
                $error = \Illuminate\Validation\ValidationException::withMessages(collect($result['message'])->toArray());
                throw $error;
            } else {
                return redirect()->back()->withInput()->with( $alert , $result['message'] );
            }
        }
        return redirect()->back()->with( $alert ,$result['message'] );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(DeleteRoleRequest $request, $role_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'role_uuid' => $role_uuid
            ];
            app('DeleteRole')->execute($input_dto,true);
            DB::commit();
            $message = 'Role berhasil dihapus';
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
    public function grid(Request $request)
    {
        if (have_permission('role_view')) {

            $request->merge([
                'per_page' => $request->length,
                'page' => $request->start/$request->length + 1,
                'with_pagination' => true,
                'search_param' => $request->search['value'] ?? null
            ]);

            $role = app('GetRole')->execute($request->all());
            return datatables($role['data'])->skipPaging()
            ->with(["recordsTotal"    => $role['pagination']['total_data'],
            "recordsFiltered" => $role['pagination']['total_data'],
            ])
            ->rawColumns(['action'])
            ->addColumn('action', function ($row) {
                if (!in_array($row->id, [1])) {
                    $action = [];
                    (have_permission('assign_permission_to_role_add_remove_permission')) ? array_push($action, "<a href='".route('role.permission', [$row->uuid])."' class='dropdown-item font-action'>Permission</a>") : null;
                    (have_permission('role_edit')) ? array_push($action, "<a href='".route('role.edit', [$row->uuid])."' class='edit dropdown-item font-action'>Edit</a>") : null;
                    (have_permission('role_delete')) ? array_push($action, "<button value='$row->uuid' class='delete dropdown-item font-action' >Delete</button>") : null;
                    return generate_action_button($action);
                }
            })
            ->toJson();
        }

        return response()->json([
            'success' => false
        ],403);
    }
}
