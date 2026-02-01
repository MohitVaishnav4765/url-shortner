<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendMailEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InviteCompanyAdminRequest;
use App\Http\Requests\Admin\InviteUsersRequest;
use App\Http\Requests\Admin\ShortUrlRequest;
use App\Listeners\SendMailListener;
use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str as SupportStr;
use Psy\Util\Str;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    public function inviteAdminForm(){
        $admins = User::whereHas('roles' ,function($roles){
            $roles->where('name','Admin');
        })->select('id','name','email')->get();

        return view('admin.company.invite',compact(['admins']));
    }

    public function adminInviteSend(InviteCompanyAdminRequest $request){
        $validated = $request->validated();
        $company = Company::create([
            'name' => $validated['company_name']
        ]);

        if(filled($company)){
            if($validated['admin_type'] == 'NEW'){
                $password = 'Admin@'.SupportStr::slug($company->name).rand(0,9999);
                $user = User::create([
                    'name' => $validated['user_name'],
                    'email' => $validated['user_email'],
                    'password' => Hash::make($password),
                ]);
                $user->assignRole('Admin');

                event(new SendMailEvent(SendMailListener::INVITE_EXISTING_COMPANY_ADMIN,$user,$company,$password));
                $company->users()->attach($user->id);
            }else if($validated['admin_type'] == 'EXISTING'){
                $user = User::find($validated['admin_id']);
                $company->users()->attach($validated['admin_id']);

                event(new SendMailEvent(SendMailListener::INVITE_EXISTING_COMPANY_ADMIN,$user,$company));
            }
            
            return redirect()->route('dashboard')->with('success','Invitation send successfully.');

        }

        return redirect()->back()->with('error','Failed a invite new client.');
    }

    public function view(Request $request,Company $company) {
        $title = $company->name;
        $tab = $request->tab ?? '';
        return view('admin.company.view',compact(['company','title','tab']));
    }

    public function users(Request $request, Company $company){
        if($request->ajax()){
            $users = User::whereHas('companies',function($query) use($company){
                $query->where('company_id',$company->id);
            })->whereNot('id',Auth::guard('web')->id());
            return DataTables::of($users)
            ->addColumn('role',function($user){
                return $user->roles->pluck('name')->join(',');
            })
            ->make(true);
        }
    }

    public function inviteUserForm(Company $company){
        $roles = Role::whereNot('name','SuperAdmin')->get();
        return view('admin.company.invite_users',compact(['company','roles']));
    }

    public function inviteUser(InviteUsersRequest $request, Company $company){
        $validated = $request->validated();

        $password = $validated['role'].'@'.SupportStr::slug($company->name).rand(0,9999);
        $validated['password'] = Hash::make($password);

        $validated['company_id'] = $company->id;

        $user = User::create($validated);
        if(filled($user)){
            $user->assignRole($validated['role']);
            $company->users()->attach($user->id);

            if($validated['role'] == 'Admin'){
                $type = SendMailListener::INVITE_NEW_COMPANY_ADMIN;
            }else if($validated['role'] == 'Member'){
                $type = SendMailListener::INVITE_COMPANY_MEMBER;
            }

            
            event(new SendMailEvent($type,$user,$company,$password));

            return redirect()->route('company.view',['company' => $company->id,'tab' => 'users'])->with('success','Invitation send successfully.');
        }

        return redirect()->back()->with('error','Failed to invite user. Please try again.');
    }

    public function generateShortUrlForm(Company $company){
        return view('admin.company.generate_url_form',compact(['company']));
    }

    public function generateShortUrl(ShortUrlRequest $request,Company $company){
        $validated = $request->validated();

        $validated['hits'] = 0;
        $validated['company_id'] = $company->id;
        $validated['user_id'] = Auth::guard('web')->id();

        $short_url = ShortUrl::create($validated);

        if(filled($short_url)){
            return redirect()->back()->with('success','Short URL generated successfully.');
        }

        return redirect()->back()->with('error','Failed to generate short URL. Please try again.');
    }

    public function urls(Request $request,Company $company){
        if($request->ajax()){
            $urls = ShortUrl::where('company_id',$company->id);

            return DataTables::of($urls)
            ->editColumn('short_code',function($url){
                return '<a href="'.config('app.url').'/'.$url->short_code.'" target="_blank">'.config('app.url').'/'.$url->short_code.'</a>';
            })
            ->editColumn('original_url',function($url){
                return '<a href="'.$url->original_url.'" target="_blank">'.$url->original_url.'</a>';
            })
            ->rawColumns(['short_code','original_url'])
            ->make(true);
        }
    }
}
