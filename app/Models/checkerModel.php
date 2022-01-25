<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class checkerModel extends Model
{

    /*-----------------------------------------*/
    /**
     * Kullanıcının belirtilen elemana erişim izninin olup olmadığını kontrol eder.
     * 
     * PARAMETRELER
     * $user = izni referans alınacak kullanıcının bilgileri
     * $target = kontrol edilecek elemanın ismi
     * $target = 'lenet'
     * 
     * return true/false
     * 
     */
    public static function checkUserPermission($user,$target){

        $userRole = $user['role'];
        $targetRoles = DB::table('components')->where('name',$target)->value('permissions');
        $targetRoles = explode(',',$targetRoles);
        
        if(in_array($userRole,$targetRoles)){
            
            return true;

        }

        else{
            return false;
        }
        

    }
    /*-----------------------------------------*/


    /*-----------------------------------------*/
    /**
     * Parametre olarak verilen bir elementin aktif olup olmadığını kontrol eder.
     * 
     * Sistemde varolan bütün işleve sahip fonksiyonlar aynı zamanda veritabanında saklanır.
     * Örneğin veritabanında lenet, vgg16, rotate gibi fonksiyonlar kayıtlıdır. Bu fonksiyonların aktif veya pasif
     * olduğnu belirten bir status değeri vardır. Eğer fonksiyon aktif ise status 1, değil ise 0'dır.
     * 
     * return true/false/1
     * 
     * Eğer sistem 1 değerini dönderiyorsa o halde kullanıcının günlük kullanım sayısı sıfırlanmalıdır.
     */
    public static function checkStatus($target)
    {
        
        return DB::table('components')->where('name',$target)->value('status');
    }

    public static function checkUsagePerDay($user,$target){
        $check = DB::table('roles')->where('name',$user['role'])->value('usage_per_day');
        
        
        if(time() - strtotime($user['last_train_time'] > 3600 && $check)){
            return 1;
        }

        if($user['usage_count']<$check && $check ){
            return true;
        }

        else{

            return false;
        }
    }
    /*-----------------------------------------*/
}
