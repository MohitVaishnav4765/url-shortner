<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::get('login','showLoginPage')->name('login');
    Route::post('login','login')->name('do_login');
});

Route::middleware(['auth:web'])->group(function(){
    Route::get('logout',[AuthController::class,'logout'])->name('logout');
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware('can_access_dashboard');

    Route::get('companies/invite',[CompanyController::class,'inviteAdminForm'])->name('company.invite.admin')->middleware('role:SuperAdmin');

    Route::post('companies/invite',[CompanyController::class,'adminInviteSend'])->name('company.invite.admin.send')->middleware('role:SuperAdmin');

    Route::get('companies/{company}',[CompanyController::class,'view'])->name('company.view');

    Route::get('companies/{company}/users',[CompanyController::class,'users'])->name('company.users')->middleware('role:Admin|SuperAdmin');

    Route::get('companies/{company}/users/invite',[CompanyController::class,'inviteUserForm'])->name('company.users.invite.form')->middleware('role:Admin|SuperAdmin');

    Route::post('companies/{company}/users/invite',[CompanyController::class,'inviteUser'])->name('company.users.invite')->middleware('role:Admin|SuperAdmin');

    Route::get('companies/{company}/generate-short-url',[CompanyController::class,'generateShortUrlForm'])->name('company.generate.short.url.form')->middleware('role:Admin|SuperAdmin|Member');

    Route::post('companies/{company}/generate-short-url',[CompanyController::class,'generateShortUrl'])->name('company.generate.short.url')->middleware('role:Admin|SuperAdmin|Member');

    Route::get('companies/{company}/urls',[CompanyController::class,'urls'])->name('company.urls')->middleware('role:Admin|SuperAdmin|Member');

    Route::get('member/companies/{company}',[MemberController::class,'viewCompany'])->name('member.company.view')->middleware('role:Member');

    Route::get('{short_code}',[UrlController::class,'index']);
});
