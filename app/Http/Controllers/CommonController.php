<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CommonController extends Controller
{
    public function home(){
        return view('home');
    }

    public function dokumen(){  
        return view('dokumen');
    }

    public function check(){  
        return view('check');
    }

    public function history(){  
        return view('history');
    }

    public function profile(){ 
        return view('profile');  
    }
}
