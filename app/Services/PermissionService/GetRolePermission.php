<?php
namespace App\Services\PermissionService;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetRolePermission extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);

        // $permission = Permission::all();
        $module_name = Permission::select('module_name')->distinct()->orderBy('module_name')->groupBy('module_name')->get();
        $role = Role::find($dto['role_id']);

        $data = $module_name->map(function ($item) use ($dto, $role) {
            $permission_per_role = Permission::where('module_name',$item->module_name)->get();
            return [
                'label' => $item->module_name,
                'permissions' => $permission_per_role->map(function ($q) use ($dto, $role) {
                    $check = RolePermission::where('role_id', $dto['role_id'])->where('permission_id', $q->id);
                    $check->count() > 0 ? $permit = true : $permit = false;
                    return [
                        'permission_uuid' => $q->uuid,
                        'module_key' => $q->module_key,
                        'module_name' => $q->module_name,
                        'permission_name' => $q->permission_name,
                        'full_module_name' => $q->permission_name. ' '. $q->module_name,
                        'role' => $role->name,
                        'role_uuid' => $role->uuid,
                        'permitted' => $permit
                    ];
                })
            ];
        });

        // $permission = Permission::all();
        // $role = Role::find($dto['role_id']);

        // $data = $permission->transform(function ($item) use ($dto, $role) {
        //     $check = RolePermission::where('role_id', $dto['role_id'])->where('permission_id', $item->id);
        //     $check->count() > 0 ? $permit = true : $permit = false;
        //     return [
        //         'permission_uuid' => $item->uuid,
        //         'module_key' => $item->module_key,
        //         'module_name' => $item->module_name,
        //         'permission_name' => $item->permission_name,
        //         'full_module_name' => $item->permission_name. ' '. $item->module_name,
        //         'role' => $role->name,
        //         'role_uuid' => $role->uuid,
        //         'permitted' => $permit
        //     ];
        // });


        $this->results['data'] = $data;
        $this->results['message'] = "Role Permission data successfully fetched";
    }

    public function prepare ($dto) {
        $dto['role_id'] = $this->findIdByUuid(Role::query(), $dto['role_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'role_uuid' => ['required','uuid', new ExistsUuid('roles')],
        ];
    }

}
