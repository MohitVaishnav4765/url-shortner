<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function viewCompany(Company $company){
        return view('member.company.view',compact(['company']));
    }
}
