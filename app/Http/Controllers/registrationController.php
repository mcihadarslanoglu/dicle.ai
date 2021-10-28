<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\userFolderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required '
        ]);
        /*-----------------------------------------*/

        /*-----------------------------------------*/
        /*Kullanıcı verilerinin veritabanına kayıt edilmesi için request fonksiyonu ile değişkenlere atanır.*/ 
        $name = request()->input('name');
        $password = Hash::make(request()->input('password'));
        $email = request()->input('email');
        /*-----------------------------------------*/
        
        /*-----------------------------------------*/
        /*Kullanıcı adına oluşturulan klasörün ismini rastgele seçmek için kullanıcı adı ve email adresi bir hash algoritmasından geçirilir.*/
        $foldername = hash('sha256',$name.$email);
        /*-----------------------------------------*/

        /*-----------------------------------------*/
        /**
         * Bu email adresinin daha önce kullanılıp kullanılmadığı kontrol edilir.
         */
        if($this->existsUser($email)){
            return 'Bu email adresi zaten sistemde kayıtlı !';
        }
        /*-----------------------------------------*/
        
        /*-----------------------------------------*/
        /*Kullanıcı bilgilerinin veritabanında saklanması için bir SQL sorgusu yapılır.*/
        DB::table('users')->insert(
            ['email' => $email, 'name' => $name, 'password'=>$password,'foldername'=>$foldername]
        );
        /*-----------------------------------------*/

        /*-----------------------------------------*/
        /**
         * Sisteme kayıt edilen kullanıcının klasmr ağacını oluşturur.
         */
        userFolderModel::initUserFolders($foldername);
        /*-----------------------------------------*/
        
        /*-----------------------------------------*/
        /*Kayıt olan kullanıcının giriş yapma işlemi için kullanıcı bilgileri credentials değişkenine atanır.
        *Daha sonra loginController içerisindeki public static fonksiyon çağırılarak kullanıcıyı sisteme giriş yaptırılır.
        *credentials değişkeni kullanıcının email ve password bilgilerini içerir.
        */
        $credentials = request()->only('email', 'password');
        return loginController::loginWithParameters($credentials);
        /*-----------------------------------------*/
       
        
    
      
        
    }

    /*-----------------------------------------*/
    /**
     * girdi olarak alınan email adresi üzerine kayıtlı bir kullanıcının olup olmadığı kontrol edilir.
     * $email = test@email.com
     */
    function existsUser($email){
        
        if(User::where('email','=',$email)->exists()){

            return True;
        }

        else{
            return False;
        }
    }
    /*-----------------------------------------*/
    static function test(){
        return 'test';
    }
} 
 
 
 
