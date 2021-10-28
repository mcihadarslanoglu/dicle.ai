<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
config('pathConfig');
class userFolderModel extends Model
{   

    /*-----------------------------------------*/
    /**
     * Yeni oluşturulan kullanıcıların klasör yapısını oluşturur.
     * 
     * PARAMETRELER
     * $folderPath = hash('sha256',$name.$email);
     * 
     * KLASÖR AĞACI
     * -users
     *  -folderPath
     *      - image-classification
     *          - datasets
     *          - trained-datasets
     *      - object-detection
     *      - logs
     * 
     * object-detection klasör yapısı için güncelleme yapılması gerekiyor. Nasıl güncelleneceği ise image-classification aşaması bittikten sonra konuşulacak.
     */
    public static function initUserFolders(String $folderPath){
        
        userFolderModel::createFolder(__USERFOLDERS__."\\".$folderPath);
        userFolderModel::createFolder(__USERFOLDERS__."\\".$folderPath."\logs"); 
        userFolderModel::createFolder(__USERFOLDERS__."\\".$folderPath."\object-detection");
        
        
        userFolderModel::createFolder(__USERFOLDERS__."\\".$folderPath."\image-classification");
        userFolderModel::createFolder(__USERFOLDERS__."\\".$folderPath."\image-classification\\trained-datasets");
        userFolderModel::createFolder(__USERFOLDERS__."\\".$folderPath."\image-classification\\datasets");
        
    }
    /*-----------------------------------------*/

    /**
     * Kullanıcıların sahip oldukları klasörler içinde klasör oluşturulmasını sağlar. Eğer klasör daha önce oluşturulmus ise UFEM1 hata kodu döndürülür.
     * Klasör başarıyla oluşturulursa True değerini döndürür.
     * 
     * PARAMETRELER
     * $folderPath: klasörün oluşturulacağı yerin tam yolu.
     * $mode: Windowsda bir etkisi olmayan fakat linux sunucularda klasör erişim izni. Varsayılan olarak 0777 yani bütün izinler tam yetkide.
     * $recursive: Eğer yol olarak verilen klasörlerden herhangi biri eksik ise sistem onu da olulstursun mu oluşturmasın mı.
     * 
     */
    /*-----------------------------------------*/
    public static function createFolder($folderPath, $mode = 0777,$recursive = False){

        if(is_dir($folderPath)){
            return "UFEM1";
        }
        else {
            mkdir($pathname = $folderPath, $mode = $mode, $recursive = $recursive);
            return True;
        }
    }
    /*-----------------------------------------*/
    
}
