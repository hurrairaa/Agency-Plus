<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SummernoteController extends Controller
{
    public function upload(Request $request) {
        $img = $request->file('image');
        $filename = uniqid() . '.' . $img->getClientOriginalExtension();
        $img->move('assets/front/img/summernote/', $filename);

        return url('/') . "/assets/front/img/summernote/" . $filename;
    }
}
