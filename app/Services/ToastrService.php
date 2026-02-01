<?php

namespace App\Services;

class ToastrService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function success($message){
        session()->flash('toastr' ,[
            'message' => $message,
            'type' => 'success'
        ]);
    }

    public function error($message){
        session()->flash('toastr' ,[
            'message' => $message,
            'type' => 'error'
        ]);
    }
}
