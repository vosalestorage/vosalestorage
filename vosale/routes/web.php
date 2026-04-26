<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Bar\ItemController as BarItemController;
use App\Http\Controllers\Bar\StockController as BarStockController;
use App\Http\Controllers\Bar\ReportController as BarReportController;
use App\Http\Controllers\Kitchen\ItemController as KitchenItemController;
use App\Http\Controllers\Kitchen\StockController as KitchenStockController;
use App\Http\Controllers\Kitchen\ReportController as KitchenReportController;

Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth','role:super_admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', function() {
        $totalBar     = \App\Models\Item::where('module','bar')->count();
        $totalKitchen = \App\Models\Item::where('module','kitchen')->count();
        $masukHariIni = \App\Models\StockTransaction::whereDate('created_at',today())->where('type','in')->count();
        $lowStock     = \App\Models\Item::whereColumn('stock','<=','minimum_stock')->count();
        return view('admin.dashboard', compact('totalBar','totalKitchen','masukHariIni','lowStock'));
    })->name('dashboard');
});

Route::middleware(['auth','role:bar,super_admin'])->prefix('bar')->name('bar.')->group(function() {
    Route::get('/dashboard', function() {
        $totalItems    = \App\Models\Item::where('module','bar')->count();
        $masukHariIni  = \App\Models\StockTransaction::whereHas('item',fn($q)=>$q->where('module','bar'))->where('type','in')->whereDate('created_at',today())->count();
        $keluarHariIni = \App\Models\StockTransaction::whereHas('item',fn($q)=>$q->where('module','bar'))->where('type','out')->whereDate('created_at',today())->count();
        $lowStock      = \App\Models\Item::where('module','bar')->whereColumn('stock','<=','minimum_stock')->count();
        $items         = \App\Models\Item::with('category')->where('module','bar')->latest()->take(10)->get();
        return view('bar.dashboard', compact('totalItems','masukHariIni','keluarHariIni','lowStock','items'));
    })->name('dashboard');
    Route::resource('items', BarItemController::class);
    Route::get('/stock/in',   [BarStockController::class,'inIndex'])->name('stock.in');
    Route::post('/stock/in',  [BarStockController::class,'storeIn'])->name('stock.in.store');
    Route::get('/stock/out',  [BarStockController::class,'outIndex'])->name('stock.out');
    Route::post('/stock/out', [BarStockController::class,'storeOut'])->name('stock.out.store');
    Route::get('/stock',      [BarStockController::class,'history'])->name('stock.index');
    Route::get('/report',     [BarReportController::class,'index'])->name('report');
});

Route::middleware(['auth','role:kitchen,super_admin'])->prefix('kitchen')->name('kitchen.')->group(function() {
    Route::get('/dashboard', function() {
        $totalItems    = \App\Models\Item::where('module','kitchen')->count();
        $masukHariIni  = \App\Models\StockTransaction::whereHas('item',fn($q)=>$q->where('module','kitchen'))->where('type','in')->whereDate('created_at',today())->count();
        $keluarHariIni = \App\Models\StockTransaction::whereHas('item',fn($q)=>$q->where('module','kitchen'))->where('type','out')->whereDate('created_at',today())->count();
        $lowStock      = \App\Models\Item::where('module','kitchen')->whereColumn('stock','<=','minimum_stock')->count();
        $items         = \App\Models\Item::with('category')->where('module','kitchen')->latest()->take(10)->get();
        return view('kitchen.dashboard', compact('totalItems','masukHariIni','keluarHariIni','lowStock','items'));
    })->name('dashboard');
    Route::resource('items', KitchenItemController::class);
    Route::get('/stock/in',   [KitchenStockController::class,'inIndex'])->name('stock.in');
    Route::post('/stock/in',  [KitchenStockController::class,'storeIn'])->name('stock.in.store');
    Route::get('/stock/out',  [KitchenStockController::class,'outIndex'])->name('stock.out');
    Route::post('/stock/out', [KitchenStockController::class,'storeOut'])->name('stock.out.store');
    Route::get('/stock',      [KitchenStockController::class,'history'])->name('stock.index');
    Route::get('/report',     [KitchenReportController::class,'index'])->name('report');
});

// Bar Export
Route::middleware(['auth','role:bar,super_admin'])->prefix('bar')->name('bar.')->group(function() {
    Route::get('/export/excel', [\App\Http\Controllers\Bar\ReportController::class,'exportExcel'])->name('export.excel');
    Route::get('/export/pdf',   [\App\Http\Controllers\Bar\ReportController::class,'exportPdf'])->name('export.pdf');
});

// Kitchen Export
Route::middleware(['auth','role:kitchen,super_admin'])->prefix('kitchen')->name('kitchen.')->group(function() {
    Route::get('/export/excel', [\App\Http\Controllers\Kitchen\ReportController::class,'exportExcel'])->name('export.excel');
    Route::get('/export/pdf',   [\App\Http\Controllers\Kitchen\ReportController::class,'exportPdf'])->name('export.pdf');
});

// Forgot Password
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));
    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', 'Link reset password telah dikirim ke email kamu!')
        : back()->withErrors(['email' => 'Email tidak ditemukan.']);
})->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill(['password' => Hash::make($password), 'remember_token' => Str::random(60)])->save();
        }
    );
    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login.')
        : back()->withErrors(['email' => 'Token tidak valid atau kadaluarsa.']);
})->name('password.update');

// Admin User Management
Route::middleware(['auth','role:super_admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
});
