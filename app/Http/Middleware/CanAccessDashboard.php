<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class CanAccessDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();
        if(filled($user)){
            $role = $user->roles->first();
            if($role->name != 'SuperAdmin'){
                $companies = $user->companies()->count();
                
                if($companies < 2){
                    $company = $user->companies->first();
                    if($role->name == 'Admin'){
                        return redirect()->route('company.view',['company' => $company->id,'tab' => 'users']);
                    }elseif($role->name == 'Member'){
                        return redirect()->route('member.company.view',$company->id);
                        return $next($request);                
                    }
                }
            }
        }
        
        return $next($request);
    }
}
