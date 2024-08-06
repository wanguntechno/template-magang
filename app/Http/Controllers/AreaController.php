<?php
namespace App\Http\Controllers;

use App\Http\Requests\Area\CreateAreaRequest;
use App\Http\Requests\Area\DeleteAreaRequest;
use App\Http\Requests\Area\EditAreaRequest;
use App\Http\Requests\Area\GetAreaRequest;
use App\Http\Requests\Area\StoreAreaRequest;
use App\Http\Requests\Area\UpdateAreaRequest;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function index(GetAreaRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/area','name' => 'Area']
        ];

        return view('area.index', [
            'breadcrumb' => breadcrumb($breadcrumb)
        ]);
    }
    
    public function create(CreateAreaRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/area','name' => 'Area'],
            ['link' => '/area/create','name' => 'Create']
        ];

        return view('area.create', [
            'breadcrumb' => breadcrumb($breadcrumb),
        ]);
    }

    public function store(StoreAreaRequest $request)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'name' => $request->area_name,
                'code' => $request->area_code,
                'description' => $request->area_description,
            ];

            app('StoreArea')->execute($input_dto, true);

            $alert = 'success';
            $message = 'Area berhasil dibuat';
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    public function edit(EditAreaRequest $request, $area_uuid)
    {
        $area = app('GetArea')->execute([
            'area_uuid' => $area_uuid
        ]);

        if (empty($area['data']))
        return view('errors.404');

        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/area','name' => 'Area'],
            ['link' => "/area/$area_uuid/edit",'name' => 'Edit']
        ];

        return view('area.edit', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'area' => $area['data'],
        ]);
    }

    public function update(UpdateAreaRequest $request, $area_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'area_uuid' => $area_uuid,
                'name' => $request->area_name,
                'code' => $request->area_code,
                'description' => $request->area_description,
            ];
            app('UpdateArea')->execute($input_dto,true);

            $alert = 'success';
            $message = 'Area berhasil diubah';
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    public function destroy(DeleteAreaRequest $request, $area_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'area_uuid' => $area_uuid
            ];

            app('DeleteArea')->execute($input_dto,true);
            DB::commit();

            $message = 'Area berhasil dihapus';
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

    public function grid(GetAreaRequest $request)
    {
        $request->merge([
            'per_page' => $request->length,
            'page' => $request->start/$request->length + 1,
            'with_pagination' => true,
            'search_param' => $request->search['value']
        ]);

        $area = app('GetArea')->execute($request->all());

        return datatables($area['data'])->skipPaging()
        ->with(["recordsTotal" => $area['pagination']['total_data'],
        ])
        ->rawColumns(['action'])
        ->addColumn('action', function ($row) {
            $action = [];
            (have_permission('area_edit')) ? array_push($action, "<a href='".route('area.edit', [$row->uuid])."' class='edit dropdown-item font-action'>Edit</a>") : null;
            (have_permission('area_delete')) ? array_push($action, "<button value='$row->uuid' class='delete dropdown-item font-action' >Delete</button>") : null;
            return generate_action_button($action);
        })
        ->toJson();
    }
}