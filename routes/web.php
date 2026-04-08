<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
Route::patch('/admin/users/{user}/ban', [AdminUserController::class, 'ban'])->name('admin.users.ban');
Route::patch('/admin/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset-password');
Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');
Route::get('/warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');
Route::post('/warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');
Route::get('/warehouses/{warehouse}', [WarehouseController::class, 'show'])->name('warehouses.show');
Route::post('/warehouses/{warehouse}/join', [WarehouseController::class, 'join'])->name('warehouses.join');
Route::post('/warehouses/{warehouse}/invite', [WarehouseController::class, 'invite'])->name('warehouses.invite');
Route::patch('/warehouses/{warehouse}/transfer-ownership', [WarehouseController::class, 'transferOwnership'])->name('warehouses.transfer-ownership');

Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('products', ProductController::class);

Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
Route::patch('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::patch('/invitations/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');

Route::get('/warehouses/{warehouse}/items', [ItemController::class, 'index'])->name('warehouses.items.index');
Route::get('/warehouses/{warehouse}/items/create', [ItemController::class, 'create'])->name('warehouses.items.create');
Route::post('/warehouses/{warehouse}/items', [ItemController::class, 'store'])->name('warehouses.items.store');
Route::get('/warehouses/{warehouse}/items/{item}', [ItemController::class, 'show'])->name('warehouses.items.show');
Route::get('/warehouses/{warehouse}/items/{item}/edit', [ItemController::class, 'edit'])->name('warehouses.items.edit');
Route::match(['put', 'patch'], '/warehouses/{warehouse}/items/{item}', [ItemController::class, 'update'])->name('warehouses.items.update');
Route::delete('/warehouses/{warehouse}/items/{item}', [ItemController::class, 'destroy'])->name('warehouses.items.destroy');

Route::post('/warehouses/{warehouse}/leave', [WarehouseController::class, 'leave'])->name('warehouses.leave');
Route::delete('/warehouses/{warehouse}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');
Route::post('/warehouses/{warehouse}/comments', [WarehouseController::class, 'addComment'])->name('warehouses.comments.store');
