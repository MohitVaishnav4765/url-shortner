<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Auth;


class DashboardController extends Controller
{
    public function index(Request $request){
        $title = 'Dashboard';
        if($request->ajax()){
            $companies = Company::withCount(['users','urls'])->withSum('urls','hits')->where(function($query){
                if(Auth::guard('web')->user()->hasRole('SuperAdmin') == false){
                    $query->whereHas('users',function($users){
                        $users->where('user_id',Auth::guard('web')->id());
                    });
                }
            })->get();
            return DataTables::of($companies)
            ->editColumn('users_count',function($company){
                return '<a href="'.route('company.view',['company' => $company->id,'tab' => 'users']).'">'.$company->users_count.'</a>';
            })
            ->editColumn('urls_count',function($company){
                return '<a href="'.route('company.view',['company' => $company->id,'tab' => 'urls']).'">'.$company->urls_count.'</a>';
            })
            ->editColumn('urls_sum_hits',function($company){
                return round($company->urls_sum_hits);
            })
            ->addColumn('action',function($company){
                return '<a href="'.route('company.view',['company' => $company->id,'tab' =>'users']).'" class="btn btn-outline-info"><i class="bi bi-pen"></i></a>';
            })
            ->rawColumns(['action','users_count','urls_count'])
            ->make(true);
        }

        return view('admin.dashboard',compact(['title']));
    }
}
