<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function index(String $short_code){
        $short_url = ShortUrl::where('short_code',$short_code)->first();
        if(!filled($short_url)){
            abort(404);
        }

        $short_url->increment('hits');

        return redirect($short_url->original_url);
    }
}
