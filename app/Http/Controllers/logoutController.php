<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


class logoutController extends Controller{

    /*-----------------------------------------*/
    /**
     * Sisteme giriş yapmış olan kullanıcının çıkışını yapar.
     */
    function logout(){
        Auth::logout();
        return redirect("checkLogin");

    }
   
}
?>