<?php
namespace App\Http\Controllers;

use App\Http\Requests\ItemCategory\CreateItemCategoryRequest;
use App\Http\Requests\ItemCategory\DeleteItemCategoryRequest;
use App\Http\Requests\ItemCategory\EditItemCategoryRequest;
use App\Http\Requests\ItemCategory\GetItemCategoryRequest;
use App\Http\Requests\ItemCategory\StoreItemCategoryRequest;
use App\Http\Requests\ItemCategory\UpdateItemCategoryRequest;
use Illuminate\Support\Facades\DB;

class ItemCategoryController extends Controller
{
    public function index(GetItemCategoryRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/item-category','name' => 'Item Category']
        ];

        return view('item_category.index', [
            'breadcrumb' => breadcrumb($breadcrumb),
        ]);
    }

    public function create(CreateItemCategoryRequest $request)
    {
        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/item-category','name' => 'Item Category'],
            ['link' => '/item-category/create','name' => 'Create']
        ];

        return view('item_category.create', [
            'breadcrumb' => breadcrumb($breadcrumb),
        ]);
    }

    public function store(StoreItemCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'name' => $request->item_category_name,
                'code' => $request->item_category_code,
                'description' => $request->item_category_description,
            ];

            app('StoreItemCategory')->execute($input_dto, true);

            $alert = 'success';
            $message = 'Item Category berhasil dibuat';
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    public function edit(EditItemCategoryRequest $request, $item_category_uuid)
    {
        $item_category = app('GetItemCategory')->execute([
            'item_category_uuid' => $item_category_uuid
        ]);

        if (empty($item_category['data']))
        return view('errors.404');

        $breadcrumb = [
            ['link' => '/','name' => 'Dashboard'],
            ['link' => '/item-category','name' => 'Item Category'],
            ['link' => "/item-category/$item_category_uuid/edit",'name' => 'Edit']
        ];

        return view('item_category.edit', [
            'breadcrumb' => breadcrumb($breadcrumb),
            'item_category' => $item_category['data']
        ]);
    }

    public function update(UpdateItemCategoryRequest $request, $item_category_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'item_category_uuid' => $item_category_uuid,
                'name' => $request->item_category_name,
                'code' => $request->item_category_code,
                'description' => $request->item_category_description,
            ];
            app('UpdateItemCategory')->execute($input_dto,true);

            $alert = 'success';
            $message = 'Item Category berhasil diubah';
            DB::commit();
            return redirect()->back()->with($alert,$message);
        }catch (\Exception $ex) {
            DB::rollback();
            $alert = 'danger';
            $message = $ex->getMessage();
            return redirect()->back()->withInput()->with($alert,$message);
        }
    }

    public function destroy(DeleteItemCategoryRequest $request, $item_category_uuid)
    {
        DB::beginTransaction();
        try {
            $input_dto = [
                'item_category_uuid' => $item_category_uuid
            ];

            app('DeleteItemCategory')->execute($input_dto,true);
            DB::commit();

            $message = 'Item Category berhasil dihapus';
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

    public function grid(GetItemCategoryRequest $request)
    {
        $request->merge([
            'per_page' => $request->length,
            'page' => $request->start/$request->length + 1,
            'with_pagination' => true,
            'search_param' => $request->search['value']
        ]);

        $item_category = app('GetItemCategory')->execute($request->all());

        return datatables($item_category['data'])->skipPaging()
        ->with(["recordsTotal" => $item_category['pagination']['total_data'],
        ])
        ->rawColumns(['action'])
        ->addColumn('action', function ($row) {
            $action = [];
            (have_permission('item_category_edit')) ? array_push($action, "<a href='".route('item-category.edit', [$row->uuid])."' class='edit dropdown-item font-action'>Edit</a>") : null;
            (have_permission('item_category_delete')) ? array_push($action, "<button value='$row->uuid' class='delete dropdown-item font-action' >Delete</button>") : null;
            return generate_action_button($action);
        })
        ->toJson();
    }
}