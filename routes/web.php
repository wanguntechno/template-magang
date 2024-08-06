<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'notifikasi'], function () {
        Route::get('', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification');
        Route::put('read/{uuid}', [App\Http\Controllers\NotificationController::class, 'readNotification'])->name('notification.read');
        Route::get('list', [App\Http\Controllers\NotificationController::class, 'listNotification'])->name('notification.list');
        Route::get('grid', [App\Http\Controllers\NotificationController::class, 'grid'])->name('notification.grid');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::group(['prefix' => '{uuid}/permission'], function () {
            Route::get('grid', [App\Http\Controllers\PermissionController::class, 'grid'])->name('role.permission.grid');
            Route::get('', [App\Http\Controllers\PermissionController::class, 'index'])->name('role.permission');
            Route::put('update-role', [App\Http\Controllers\PermissionController::class, 'updateRole'])->name('role.permission.update-role');
        });
        Route::get('grid', [App\Http\Controllers\RoleController::class, 'grid'])->name('role.grid');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('grid', [App\Http\Controllers\UserController::class, 'grid'])->name('user.grid');
    });

    Route::group(['prefix' => 'area'], function () {
        Route::get('grid', [App\Http\Controllers\AreaController::class, 'grid'])->name('area.grid');
    });

    Route::group(['prefix' => 'tenant'], function () {
        Route::get('grid', [App\Http\Controllers\TenantController::class, 'grid'])->name('tenant.grid');

        Route::group(['prefix' => '{uuid}/tenant-user'], function () {
            Route::get('grid', [App\Http\Controllers\TenantUserController::class, 'grid'])->name('tenant.tenant-user.grid');
        });
    });

    Route::group(['prefix' => 'item-category'], function () {
        Route::get('grid', [App\Http\Controllers\ItemCategoryController::class, 'grid'])->name('item-category.grid');
    });

    Route::resource('role', App\Http\Controllers\RoleController::class,[
        'names' => [
            'index' => 'role',
            'create' => 'role.create',
            'store' => 'role.store',
            'edit' => 'role.edit',
            'update' => 'role.update',
            'delete' => 'role.delete'
        ],
    ]);

    Route::resource('user', App\Http\Controllers\UserController::class,[
        'names' => [
            'index' => 'user',
            'create' => 'user.create',
            'store' => 'user.store',
            'edit' => 'user.edit',
            'update' => 'user.update',
            'delete' => 'user.delete'
        ],
    ]);

    Route::resource('profile', App\Http\Controllers\ProfileController::class,[
        'names' => [
            'index' => 'profile',
            'update' => 'profile.update',
        ],
    ]);

    Route::resource('area', App\Http\Controllers\AreaController::class,[
        'names' => [
            'index' => 'area',
            'create' => 'area.create',
            'store' => 'area.store',
            'edit' => 'area.edit',
            'update' => 'area.update',
            'delete' => 'area.delete'
        ],
    ]);

    Route::resource('tenant', App\Http\Controllers\TenantController::class,[
        'names' => [
            'index' => 'tenant',
            'create' => 'tenant.create',
            'store' => 'tenant.store',
            'edit' => 'tenant.edit',
            'update' => 'tenant.update',
            'delete' => 'tenant.delete'
        ],
    ]);

    Route::resource('tenant/{tenant_uuid}/tenant-user', App\Http\Controllers\TenantUserController::class,[
        'names' => [
            'index' => 'tenant.tenant-user',
            'create' => 'tenant.tenant-user.create',
            'store' => 'tenant.tenant-user.store',
            'edit' => 'tenant.tenant-user.edit',
            'update' => 'tenant.tenant-user.update',
            'delete' => 'tenant.tenant-user.delete'
        ],
    ]);

    Route::resource('item-category', App\Http\Controllers\ItemCategoryController::class,[
        'names' => [
            'index' => 'item-category',
            'create' => 'item-category.create',
            'store' => 'item-category.store',
            'edit' => 'item-category.edit',
            'update' => 'item-category.update',
            'delete' => 'item-category.delete'
        ],
    ]);
});
