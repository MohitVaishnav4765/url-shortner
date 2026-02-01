<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginPage(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $validated = $request->validated();

        if(Auth::guard('web')->attempt($validated)){
            $user = Auth::guard('web')->user();
            if($user->hasRole('SuperAdmin') == false){
                $companies = $user->companies()->count();
                if($companies == 1){
                    $company = $user->companies->first();
                    $role = $user->roles->first();
                    if($role->name == 'Admin'){
                        return redirect()->route('company.view',['company' => $company->id,'tab' => 'users']);
                    }else if($role->name == 'Member'){
                        return redirect()->route('member.company.view',$company->id);
                    }
                }
            }
            
            return redirect()->route('dashboard');
        }

        return back()->with('error','invalid credentials');
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
