<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\AuthService\DoLogin;
use App\Services\AuthService\DoLogout;

use App\Services\UserService\GetUser;
use App\Services\UserService\StoreUser;
use App\Services\UserService\UpdateUser;
use App\Services\UserService\DeleteUser;
use App\Services\UserService\ChangePassword;

use App\Services\FileStorageService\StoreFileStorage;
use App\Services\FileStorageService\DeleteFileStorage;

use App\Services\RoleService\GetRole;
use App\Services\RoleService\StoreRole;
use App\Services\RoleService\UpdateRole;
use App\Services\RoleService\DeleteRole;

use App\Services\PermissionService\GetListPermissionModule;
use App\Services\PermissionService\GetRolePermission;
use App\Services\PermissionService\UpdateRolePermission;

use App\Services\UserRoleService\AddUserRole;
use App\Services\UserRoleService\RemoveUserRole;

use App\Services\NotificationService\GetNotification;
use App\Services\NotificationService\ReadNotification;
use App\Services\NotificationService\StoreNotification;

use App\Services\AreaService\GetArea;
use App\Services\AreaService\StoreArea;
use App\Services\AreaService\UpdateArea;
use App\Services\AreaService\DeleteArea;

use App\Services\TenantService\GetTenant;
use App\Services\TenantService\StoreTenant;
use App\Services\TenantService\UpdateTenant;
use App\Services\TenantService\DeleteTenant;

use App\Services\ItemCategoryService\GetItemCategory;
use App\Services\ItemCategoryService\StoreItemCategory;
use App\Services\ItemCategoryService\UpdateItemCategory;
use App\Services\ItemCategoryService\DeleteItemCategory;

use App\Services\AdminService\GetAdmin;
use App\Services\AdminService\StoreAdmin;
use App\Services\AdminService\UpdateAdmin;
use App\Services\AdminService\DeleteAdmin;

use App\Services\EndpointLogService\GetEndpointLog;
use App\Services\EndpointLogService\StoreEndpointLog;

use App\Services\AdminAreaService\AddAdminArea;
use App\Services\AdminAreaService\RemoveAdminArea;

use App\Services\TenantUserService\GetTenantUser;
use App\Services\TenantUserService\StoreTenantUser;
use App\Services\TenantUserService\UpdateTenantUser;
use App\Services\TenantUserService\DeleteTenantUser;

use App\Services\SellingGoodService\GetSellingGood;
use App\Services\SellingGoodService\StoreSellingGood;
use App\Services\SellingGoodService\UpdateSellingGood;
use App\Services\SellingGoodService\DeleteSellingGood;

use App\Services\StockLedgerService\GetStockLedger;
use App\Services\StockLedgerService\StoreStockLedger;
use App\Services\StockLedgerService\UpdateStockLedger;
use App\Services\StockLedgerService\DeleteStockLedger;

class AppServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    *
    * @return void
    */

    public function register()
    {
        $this->registerService('DoLogin', DoLogin::class);
        $this->registerService('DoLogout', DoLogout::class);

        $this->registerService('GetUser', GetUser::class);
        $this->registerService('StoreUser', StoreUser::class);
        $this->registerService('UpdateUser', UpdateUser::class);
        $this->registerService('DeleteUser', DeleteUser::class);
        $this->registerService('ChangePassword', ChangePassword::class);

        $this->registerService('StoreFileStorage', StoreFileStorage::class);
        $this->registerService('DeleteFileStorage', DeleteFileStorage::class);

        $this->registerService('GetRole', GetRole::class);
        $this->registerService('StoreRole', StoreRole::class);
        $this->registerService('UpdateRole', UpdateRole::class);
        $this->registerService('DeleteRole', DeleteRole::class);

        $this->registerService('GetListPermissionModule',GetListPermissionModule::class);
        $this->registerService('GetRolePermission',GetRolePermission::class);
        $this->registerService('UpdateRolePermission',UpdateRolePermission::class);

        $this->registerService('AddUserRole', AddUserRole::class);
        $this->registerService('RemoveUserRole', RemoveUserRole::class);

        $this->registerService('GetNotification', GetNotification::class);
        $this->registerService('ReadNotification', ReadNotification::class);
        $this->registerService('StoreNotification', StoreNotification::class);

        $this->registerService('GetNotification', GetNotification::class);
        $this->registerService('ReadNotification', ReadNotification::class);
        $this->registerService('StoreNotification', StoreNotification::class);

        $this->registerService('GetArea', GetArea::class);
        $this->registerService('StoreArea', StoreArea::class);
        $this->registerService('UpdateArea', UpdateArea::class);
        $this->registerService('DeleteArea', DeleteArea::class);

        $this->registerService('GetTenant', GetTenant::class);
        $this->registerService('StoreTenant', StoreTenant::class);
        $this->registerService('UpdateTenant', UpdateTenant::class);
        $this->registerService('DeleteTenant', DeleteTenant::class);

        $this->registerService('GetItemCategory', GetItemCategory::class);
        $this->registerService('StoreItemCategory', StoreItemCategory::class);
        $this->registerService('UpdateItemCategory', UpdateItemCategory::class);
        $this->registerService('DeleteItemCategory', DeleteItemCategory::class);

        $this->registerService('GetAdmin', GetAdmin::class);
        $this->registerService('StoreAdmin', StoreAdmin::class);
        $this->registerService('UpdateAdmin', UpdateAdmin::class);
        $this->registerService('DeleteAdmin', DeleteAdmin::class);

        $this->registerService('GetEndpointLog', GetEndpointLog::class);
        $this->registerService('StoreEndpointLog', StoreEndpointLog::class);

        $this->registerService('AddAdminArea', AddAdminArea::class);
        $this->registerService('RemoveAdminArea', RemoveAdminArea::class);

        $this->registerService('GetTenantUser', GetTenantUser::class);
        $this->registerService('StoreTenantUser', StoreTenantUser::class);
        $this->registerService('UpdateTenantUser', UpdateTenantUser::class);
        $this->registerService('DeleteTenantUser', DeleteTenantUser::class);

        $this->registerService('GetSellingGood', GetSellingGood::class);
        $this->registerService('StoreSellingGood', StoreSellingGood::class);
        $this->registerService('UpdateSellingGood', UpdateSellingGood::class);
        $this->registerService('DeleteSellingGood', DeleteSellingGood::class);

        $this->registerService('GetStockLedger', GetStockLedger::class);
        $this->registerService('StoreStockLedger', StoreStockLedger::class);
        $this->registerService('UpdateStockLedger', UpdateStockLedger::class);
        $this->registerService('DeleteStockLedger', DeleteStockLedger::class);

    }

    /**
    * Bootstrap any application services.
    *
    * @return void
    */
    public function boot()
    {
        //
    }

    private function registerService($serviceName, $className)
    {
        $this->app->singleton($serviceName, function () use ($className) {
            return new $className();
        });
    }
}
