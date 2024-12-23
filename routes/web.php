<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InertiaTestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/inertia-test', function () {
    return Inertia::render('InertiaTest');
});

Route::get('/inertia/index', [InertiaTestController::class, 'index'])->name('inertia.index');
Route::get('/inertia/show/{id}', [InertiaTestController::class, 'show'])->name('inertia.show');
Route::post('/inertia', [InertiaTestController::class, 'store'])->name('inertia.store');
Route::get('/inertia/create', [InertiaTestController::class, 'create'])->name('inertia.create');
Route::delete('/inertia/{id}', [InertiaTestController::class, 'destroy'])->name('inertia.destroy');
Route::get('/component-test', function () {
    return Inertia::render('ComponentTest');
});

Route::get('/items/{item}/add', [ItemController::class, 'add'])->name('items.add')->middleware(['auth', 'verified']);

Route::patch('/items/{item}/add', [ItemController::class, 'addorder'])->name('items.addorder')->middleware(['auth', 'verified']);

Route::resource('items', ItemController::class)
    ->middleware(['auth', 'verified']);

Route::resource('customers', CustomerController::class)
    ->middleware(['auth', 'verified']);

Route::resource('purchases', PurchaseController::class)
    ->middleware(['auth', 'verified']);

// Route::delete('/purchases/{purchase}/items/{item}', 
// [PurchaseController::class, 'removeItemFromPurchase']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
