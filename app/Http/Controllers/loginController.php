<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Auth;

class loginController extends Controller{

    public static function login($credentials){

        
        /*-----------------------------------------*/
        /**
         * $credentials değişken içerisinde verilen bilgilere göre kullanıcıyı sisteme giriş yaptırır.
         * $credentials = {'email':'test@email.com','password':'testPassword'}
         */
        if (Auth::attempt($credentials)) {
            
            return redirect()->intended('checkLogin')->withSuccess("Başarıyla giriş yapıldı !");
            
            /**
             * Alternatif redirect formu
             * return redirect()->to('checkLogin');
             */
        }
        else{
            return redirect()->back()->with('error','kullanıcı adı veya parola hatalı !');
            /**
             * Tam implementasyon için şurayı oku:
             * https://stackoverflow.com/questions/19838978/laravel-redirect-back-with-message
             */
            
        } 
    }


}

?>