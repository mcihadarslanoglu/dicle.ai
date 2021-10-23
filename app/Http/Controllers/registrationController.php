<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;
class registrationController extends Controller

{
   /* private $username;
    private $password;
    private $email;
    private $foldername;
*/
    public function create()
    {
        return view('create');
    }

    public function store()
    {
        $this->validate(request(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        /*-----------------------------------------*/
        /*Kullanıcı verilerinin veritabanına kayıt edilmesi için request fonksiyonu ile değişkenlere atanır.*/ 
        $username = request()->input('username');
        $password = Hash::make(request()->input('password'));
        $email = request()->input('email');
        /*-----------------------------------------*/
        
        /*-----------------------------------------*/
        /*Kullanıcı adına oluşturulan klasörün ismini rastgele seçmek için kullanıcı adı ve email adresi bir hash algoritmasından geçirilir.*/
        $foldername = hash('sha256',$username.$email);
        /*-----------------------------------------*/
        
        /*-----------------------------------------*/
        /*Kullanıcı bilgilerinin veritabanında saklanması için bir SQL sorgusu yapılır.*/
        DB::table('users')->insert(
            ['email' => $email, 'username' => $username, 'password'=>$password,'foldername'=>$foldername]
        );
        /*-----------------------------------------*/

        $credentials = request()->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('checkLogin')
                        ->withSuccess('Logged-in');
        }
        return redirect("login")->withSuccess('Credentials are wrong.'); 
        

        //https://stackoverflow.com/questions/39118995/difference-between-laravel-dbinsert-and-dbtable-insert
      
        
    }
    function logout(){
        Auth::logout();
        return redirect("checkLogin");
    }
} 
 
 
 
