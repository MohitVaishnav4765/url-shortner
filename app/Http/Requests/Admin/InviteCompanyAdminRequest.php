<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class InviteCompanyAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_name' => 'required',
            'admin_type' => 'required|in:EXISTING,NEW',
            'user_name' => 'required_if:admin_type,NEW',
            'user_email' => 'required_if:admin_type,NEW|nullable|email|unique:users,email',
            // 'admin_id' => 'required_if:admin_type,EXISTING'
            'admin_id' => [
    'required_if:admin_type,EXISTING',
                function($attribute,$value,$fail){
                    $user = User::where('id',$value)->whereHas('roles',function($query){
                        $query->where('name','Admin');
                    })->exists();

                    if(!filled($user)){
                        $fail("The selected admin is invalid.");
                    }
                }
            ]
        ];
    }
}
