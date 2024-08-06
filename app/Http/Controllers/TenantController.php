<?php
namespace App\Http\Controllers;

use App\Http\Requests\Tenant\CreateTenantRequest;
use App\Http\Requests\Tenant\DeleteTenantRequest;
use App\Http\Requests\Tenant\EditTenantRequest;
use App\Http\Requests\Tenant\GetTenantRequest;
use App\Http\Requests\Tenant\StoreTenantRequest;
use App\Http\Requests\Tenant\UpdateTenantRequest;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function index(GetTenantRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/tenant','name' => 'Tenant']
        ];

        $areas = app('GetArea')->execute([]);

        return view('tenant.index', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'areas' => $areas['data']
        ]);
    }

    public function create(CreateTenantRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/tenant','name' => 'Tenant'],
            ['link' => '/tenant/create','name' => 'Create']
        ];

        $areas = app('GetArea')->execute([]);

        return view('tenant.create', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'areas' => $areas['data']
        ]);
    }

    public function store(StoreTenantRequest $request)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'area_uuid' => $request->tenant_area_uuid,
                'name' => $request->tenant_name,
                'email' => $request->tenant_email,
                'phone_number' => $request->tenant_phone_number,
                'bank_account_name' => $request->tenant_bank_account_name,
                'bank_account_number' => $request->tenant_bank_account_number,  
            ];

            app('StoreTenant')->execute($input_dto, true);

            $alert = 'success';
            $message = 'Tenant berhasil dibuat';
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    public function edit(EditTenantRequest $request, $tenant_uuid)
    {
        $tenant = app('GetTenant')->execute([
            'tenant_uuid' => $tenant_uuid
        ]);

        if (empty($tenant['data']))
        return view('errors.404');

        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/tenant','name' => 'Tenant'],
            ['link' => "/tenant/$tenant_uuid/edit",'name' => 'Edit']
        ];

        $areas = app('GetArea')->execute([]);

        return view('tenant.edit', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'areas' => $areas['data'],
            'tenant' => $tenant['data']
        ]);
    }

    public function update(UpdateTenantRequest $request, $tenant_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'tenant_uuid' => $tenant_uuid,
                'area_uuid' => $request->tenant_area_uuid,
                'name' => $request->tenant_name,
                'email' => $request->tenant_email,
                'phone_number' => $request->tenant_phone_number,
                'bank_account_name' => $request->tenant_bank_account_name,
                'bank_account_number' => $request->tenant_bank_account_number,  
            ];
            app('UpdateTenant')->execute($input_dto,true);

            $alert = 'success';
            $message = 'Tenant berhasil diubah';
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    public function destroy(DeleteTenantRequest $request, $tenant_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'tenant_uuid' => $tenant_uuid
            ];

            app('DeleteTenant')->execute($input_dto,true);
            DB::commit();

            $message = 'Tenant berhasil dihapus';
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

    public function grid(GetTenantRequest $request)
    {
        $request->merge([
            'per_page' => $request->length,
            'page' => $request->start/$request->length + 1,
            'with_pagination' => true,
            'search_param' => $request->search['value']
        ]);

        $tenant = app('GetTenant')->execute($request->all());

        return datatables($tenant['data'])->skipPaging()
        ->with(["recordsTotal" => $tenant['pagination']['total_data'],
        ])
        ->rawColumns(['action', 'bank'])
        ->addColumn('bank', function ($row) {
            $bank_account_name = $row->bank_account_name;
            $bank_account_number = $row->bank_account_number;

            return 'A.n : <br> <b>' . $bank_account_name . '</b> <br> Nomor Rekening : <br><b>' . $bank_account_number . '</b>';
        })
        ->addColumn('action', function ($row) {
            $action = [];
            (have_permission('tenant_user_view')) ? array_push($action, "<a href='".route('tenant.tenant-user', [$row->uuid])."' class='edit dropdown-item font-action'>Tenant User</a>") : null;
            (have_permission('tenant_edit')) ? array_push($action, "<a href='".route('tenant.edit', [$row->uuid])."' class='edit dropdown-item font-action'>Edit</a>") : null;
            (have_permission('tenant_delete')) ? array_push($action, "<button value='$row->uuid' class='delete dropdown-item font-action' >Delete</button>") : null;
            return generate_action_button($action);
        })
        ->toJson();
    }
}