<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\{Ie_data,Agent};
use App\Http\Controllers\{
    HomeController,
    RoleController,
    UserController,
    CostCategoryController,
    OfficeCostController,
    ProfileController,
    DashboardController,
    PermissionController,
    IeDataController,
    FileDataController,
};


// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Office Costs Management
    Route::resource('cost-categories', CostCategoryController::class);
    Route::resource('office-costs', OfficeCostController::class);
    Route::get('office-costs-report', [OfficeCostController::class, 'report'])->name('office-costs.report');
    // Dashboard
    Route::get('/', [DashboardController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Cache management
    Route::prefix('cache')->group(function () {
        Route::get('/route', fn() => Artisan::call('route:cache') && 'Routes cache cleared!')->name('cache.route');
        Route::get('/config', fn() => Artisan::call('config:cache') && 'Config cache cleared!')->name('cache.config');
        Route::get('/clear', fn() => Artisan::call('cache:clear') && 'Application cache cleared!')->name('cache.clear');
        Route::get('/view', fn() => Artisan::call('view:clear') && 'View cache cleared!')->name('cache.view');
        Route::get('/optimize', fn() => Artisan::call('optimize:clear') && 'App Optimize')->name('optimize.clear');
    });

    // User management
    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'permissions' => PermissionController::class,
        'ie_datas'=> IeDataController::class,
    ]);

    Route::prefix('users')->group(function () {
        Route::get('/showuserrole/{user}', [UserController::class, 'showUserRoles'])->name('get.userrole');
        Route::post('/assignrole', [UserController::class, 'assignrole'])->name('assignrole');
        Route::post('/unassignrole', [UserController::class, 'unassignrole'])->name('unassignrole');
    });

    // Importer/Exporter management
    Route::prefix('ie_datas')->group(function () {
        Route::get('/trash', [IeDataController::class, 'trash'])->name('ie_datas.trash');
        Route::patch('/restore/{transaction}', [IeDataController::class, 'restore'])->name('ie_datas.restore');
        Route::delete('/forcedelete/{transaction}', [IeDataController::class, 'forcedelete'])->name('ie_datas.forcedelete');
    });

    Route::get('/dueimex', [IeDataController::class, 'getUnpaidFiles'])->name('dueimex');

    // Profile management
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // File Data
    Route::prefix('file_datas')->group(function () {
        Route::get('/createin', [FileDataController::class, 'createin'])->name('file_datas.createin');
    });

    // Route::resource('file_datas', FileDataController::class);
    Route::get('file_datas', [FileDataController::class, 'index'])->name('file_datas.index');
    Route::get('file_datas/create', [FileDataController::class, 'create'])->name('file_datas.create');
    Route::post('file_datas', [FileDataController::class, 'store'])->name('file_datas.store');
    Route::get('file_datas/{file_data}', [FileDataController::class, 'show'])->name('file_datas.show');
    Route::get('file_datas/{file_data}/edit', [FileDataController::class, 'edit'])->name('file_datas.edit');
    Route::put('file_datas/{file_data}', [FileDataController::class, 'update'])->name('file_datas.update');
    Route::delete('file_datas/{file_data}', [FileDataController::class, 'destroy'])->name('file_datas.destroy');

    Route::get('file_datas/{file_data}/editprint', [FileDataController::class, 'editprint'])->name('file_datas.editprint');
    Route::put('file_datas/updateprint/{file_data}', [FileDataController::class, 'updateprint'])->name('file_datas.updateprint');


    Route::get('due_file_datas', [FileDataController::class, 'dueindex'])->name('file_datas.dueindex');
    Route::get('paid_file_datas', [FileDataController::class, 'paidindex'])->name('file_datas.paidindex');

});



// Autocomplete routes
Route::get('/ieautocomplete', function (Request $request) {
    return response()->json(Ie_data::where('name', 'LIKE', "{$request->get('query')}%")->pluck('name'));
});
Route::get('/ainautocomplete', function (Request $request) {
    return response()->json(Agent::where('ain_no', 'LIKE', "%{$request->get('query')}%")
        ->orWhere('name', 'LIKE', "%{$request->get('query')}%")
        ->pluck('name'));
});


require __DIR__ . '/auth.php';
