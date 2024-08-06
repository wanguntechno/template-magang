<?php
namespace App\Http\Controllers;

use App\Http\Requests\Tenant\TenantUser\CreateTenantUserRequest;
use App\Http\Requests\Tenant\TenantUser\DeleteTenantUserRequest;
use App\Http\Requests\Tenant\TenantUser\EditTenantUserRequest;
use App\Http\Requests\Tenant\TenantUser\GetTenantUserRequest;
use App\Http\Requests\Tenant\TenantUser\StoreTenantUserRequest;
use App\Http\Requests\Tenant\TenantUser\UpdateTenantUserRequest;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class TenantUserController extends Controller
{
    public function index(GetTenantUserRequest $request, $tenant_uuid)
    {
        $tenant = app('GetTenant')->execute([
            'tenant_uuid' => $tenant_uuid
        ]);

        if (empty($tenant['data']))
        return view('errors.404');

        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/tenant','name' => 'Tenant'],
            ['link' => "/tenant/$tenant_uuid/tenant-user",'name' => 'Tenant User']
        ];

        return view('tenant.tenant_user.index', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'tenant' => $tenant['data']
        ]);
    }

    public function create(CreateTenantUserRequest $request, $tenant_uuid)
    {
        $tenant = app('GetTenant')->execute([
            'tenant_uuid' => $tenant_uuid
        ]);

        if (empty($tenant['data']))
        return view('errors.404');

        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/tenant','name' => 'Tenant'],
            ['link' => "/tenant/$tenant_uuid/tenant-user",'name' => 'Tenant User'],
            ['link' => "/tenant/$tenant_uuid/tenant-user/create",'name' => 'Create']
        ];

        return view('tenant.tenant_user.create', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'tenant' => $tenant['data'],
        ]);
    }

    public function store(StoreTenantUserRequest $request, $tenant_uuid)
    {
        DB::beginTransaction();
        try {
            $role = Role::where('deleted_at', null)->where('name', 'Tenant')->first();
            $input_dto_user = [
                'role_uuid' => $role->uuid,
                'username' => $request->tenant_user_username,
                'password' => $request->tenant_user_password,
                'password_confirmation' => $request->tenant_user_password_confirmation,
            ];

            $user = app('StoreUser')->execute($input_dto_user, true);
            
            $input_dto_tenant_user = [
                'tenant_uuid' => $tenant_uuid,
                'user_uuid' => $user['data']['uuid'],
                'name' => $request->tenant_user_name,
                'employee_number' => $request->tenant_user_employee_number,
                'phone_number' => $request->tenant_user_phone_number,
                'address' => $request->tenant_user_address,
            ];

            app('StoreTenantUser')->execute($input_dto_tenant_user, true);

            $alert = 'success';
            $message = 'Tenant User berhasil dibuat, password ' . $input_dto_user['password'];
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    public function edit(EditTenantUserRequest $request, $tenant_uuid, $tenant_user_uuid)
    {
        $tenant = app('GetTenant')->execute([
            'tenant_uuid' => $tenant_uuid
        ]);

        if (empty($tenant['data']))
        return view('errors.404');

        $tenant_user = app('GetTenantUser')->execute([
            'tenant_user_uuid' => $tenant_user_uuid
        ]);

        if (empty($tenant_user['data']))
        return view('errors.404');

        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/tenant','name' => 'Tenant'],
            ['link' => "/tenant/$tenant_uuid/tenant-user",'name' => 'Tenant User'],
            ['link' => "/tenant/$tenant_uuid/tenant-user/$tenant_user_uuid",'name' => 'Edit'],
        ];

        return view('tenant.tenant_user.edit', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'tenant' => $tenant['data'],
            'tenant_user' => $tenant_user['data']
        ]);
    }

    public function update(UpdateTenantUserRequest $request, $tenant_uuid, $tenant_user_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'tenant_user_uuid' => $tenant_user_uuid,
                'tenant_uuid' => $tenant_uuid,
                'name' => $request->tenant_user_name,
                'employee_number' => $request->tenant_user_employee_number,
                'phone_number' => $request->tenant_user_phone_number,
                'address' => $request->tenant_user_address,
            ];
            app('UpdateTenantUser')->execute($input_dto,true);

            $alert = 'success';
            $message = 'Tenant User berhasil diubah';
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    public function destroy(DeleteTenantUserRequest $request, $tenant_uuid, $tenant_user_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'tenant_user_uuid' => $tenant_user_uuid
            ];

            app('DeleteTenantUser')->execute($input_dto,true);
            DB::commit();

            $message = 'Tenant User berhasil dihapus';
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

    public function grid(GetTenantUserRequest $request, $tenant_uuid)
    {
        $request->merge([
            'per_page' => $request->length,
            'page' => $request->start/$request->length + 1,
            'with_pagination' => true,
            'search_param' => $request->search['value'],
            'tenant_uuid' => $tenant_uuid
        ]);

        $tenant_user = app('GetTenantUser')->execute($request->all());

        return datatables($tenant_user['data'])->skipPaging()
        ->with(["recordsTotal" => $tenant_user['pagination']['total_data'],
        ])
        ->rawColumns(['action'])
        ->addColumn('action', function ($row) use ($tenant_uuid) {
            $action = [];
            (have_permission('tenant_user_edit')) ? array_push($action, "<a href='".route('tenant.tenant-user.edit', [$tenant_uuid,$row->uuid])."' class='edit dropdown-item font-action'>Edit</a>") : null;
            (have_permission('tenant_user_delete')) ? array_push($action, "<button value='$row->uuid' class='delete dropdown-item font-action' >Delete</button>") : null;
            return generate_action_button($action);
        })
        ->toJson();
    }
}