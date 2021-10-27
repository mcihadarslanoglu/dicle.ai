<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
//use App\Https\loginController;
use Auth;
class registrationController extends Controller

{

    public function create()
    {
        return view('create');
    }

    public function store()
    {
        /*-----------------------------------------*/
        /*frontend tarafından gelen kayıt olma verileri belirtilen şartlara göre kontrol edilir. Eğer veriler belirlenen şartları
        *sağlamıyorsa o halde kayıt işlemi yapılmaz ve kullanıcı sayfası tekrar /register sayfasına yönlendirilir(Route)
        */
        $this->validate(request(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required '
        ]);
        /*-----------------------------------------*/

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
        return $this->isUser($email);
        /*-----------------------------------------*/
        /*Kullanıcı bilgilerinin veritabanında saklanması için bir SQL sorgusu yapılır.*/
        DB::table('users')->insert(
            ['email' => $email, 'username' => $username, 'password'=>$password,'foldername'=>$foldername]
        );
        /*-----------------------------------------*/

        /*-----------------------------------------*/
        /*Giriş yapma işlemi için kullanıcı bilgileri credentials değişkenine atanır.
        *Daha sonra loginController içerisindeki public static fonksiyon çağırılarak kullanıcıyı sisteme giriş yaptırılır.
        *credentials değişkeni kullanıcının email ve password bilgilerini içerir.
        */
        $credentials = request()->only('email', 'password');
        //return redirect()->to("checkLogin");
        return loginController::login($credentials);
        /*-----------------------------------------*/
       
    
      
        
    }

    function isUser($email){
        
        if(User::where('email','=',$email)->exists()){

            return True;
        }
    }
    
} 
 
 
 
