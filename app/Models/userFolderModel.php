<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Auth;


config('projectConfigs.pathConfigs');



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

    
    /*-----------------------------------------*/
    /**
     * Kullanıcıların sahip oldukları klasörler içinde klasör oluşturulmasını sağlar. Eğer klasör daha önce oluşturulmus ise UFEM1 hata kodu döndürülür.
     * Klasör başarıyla oluşturulursa True değerini döndürür.
     * 
     * PARAMETRELER
     * $folderPath: klasörün oluşturulacağı yerin relative yolu.
     * $mode: Windowsda bir etkisi olmayan fakat linux sunucularda klasör erişim izni. Varsayılan olarak 0777 yani bütün izinler tam yetkide.
     * $recursive: Eğer yol olarak verilen klasörlerden herhangi biri eksik ise sistem onu da olulstursun mu oluşturmasın mı.
     * 
     */

    public static function createFolder($folderPath, $mode = 0777,$recursive = False){
        #return Auth::user();
        #$folderPath = __USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.$folderPath.DIRECTORY_SEPARATOR;
        if(is_dir($folderPath)){

            return "HKK1";
           
        }
        else {
            
            mkdir($pathname = $folderPath, $mode = $mode, $recursive = $recursive);
            return True;
        }
    }
    /*-----------------------------------------*/

    /*-----------------------------------------*/
    /**
     * Verilen yolun içeriğini rekürsif olarak siler.
     * 
     * PARAMETRELER
     * $directory = silinmesi istenen dosya veya klasörün yolu.
     * 
     * return true;
     * 
     */
    public static function deleteDir($directory){
        $dirPath = __USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR;
        //return $dirPath;
        $files = array_diff( scandir($dirPath), array('.', '..') );
        foreach ($files as $file) {
            if (is_dir($file)) {
                
                self::deleteDir($dirPath.$file);
            } else {
                
                unlink($dirPath.$file);
            }
        }
        rmdir($dirPath);
    
        return true;
    }
    /*-----------------------------------------*/


    /*-----------------------------------------*/
    /**
     * Kullanıcının erişebileceği klasörlerin içeriğini döndürür.
     * Kullanıcı tarafından erişilebilen klasörler şöyle sıralanabilir;
     *  -sha256(user)
     *      -image-classification
     *          -datasets      
     *  
     *                  ↓
     *              -dataset1
     *                  -class1
     *                  -class2
     *                   ...
     *              -dataset2
     *              ...             
     *                  ↑
     * 
     *          -trained-datasets
     *      
     *                  ↓
     *              -dataset1
     *              -dataset2
     *              ... 
     *                  ↑
     * 
     *      -object-detection
     *              
     *              ↓
     *          -dataset1
     *          -dataset2
     *          ...
     *              ↑
     * 
     * Kullanıcının erişebildiği klasörlerin gerçek yolu absoltuepath değişkeni ile tutulur. Bu şekilde sistemin klasörü
     * değiştirildiği durumda bile fonksiyona gerçek yani tam yol verildiği için çalışmasında bir aksama olmayacaktır. 
     * Ayrıca bu sayede kullanıcıya sadece erişebildiği klasörlerin relative yani göreceli yolu gösterilebilecek ve kullanıcı
     * sistemdeki diğer klasörler hakkında bir bilgi sahibi olamayacaktır.
     * 
     * Fonksiyonun çıktısı bir json objesidir. Bu json objesi fonksiyonun kullanımına bağlı olarak sadece klasörleri, sadece dosyaları veya her ikisini de içerebilir.
     * Json objesi ise şu şekildedir:
     *  
     *      [{"name":"datasets","type":"folder","path":"\\image-classification\\datasets"},{"name":"trained-datasets","type":"folder","path":"\\image-classification\\trained-datasets"}]
     * 
     * 'name': İçeriğin ismini belirtir.
     * 'type': İçeriğin klasör mü yoksa dosya mı olduğunu belirtir.
     * 'path': İçeriğin relative yani göreceli yolunu belirtir.
     *      
     * PARAMETRELER
     * $directory: İçeriği listelenecek klasörün ismi.
     * $onlyFolders: Eğer TRUE değeri verilirse sadece klasörler listelenir.
     * $onlyFiles: Eğer TRUE değeri verilirse sadece dosyalar listelenir.
     * 
     * */
    public static function listFolder($directory, $onlyFolders = 0, $onlyFiles = 1){
        //return $directory;
        
        $absolutePath = __USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.$directory;
        
        $folderContentsTemp = scandir(__USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.$directory);
        $folderContentsTemp = array_diff($folderContentsTemp,['..','.']);
        
        //return var_dump($folderContentsTemp);
        $folderContents = array();
        
        foreach ($folderContentsTemp as $key => $value) {
            
            //return $absolutePath.DIRECTORY_SEPARATOR.$value.DIRECTORY_SEPARATOR;
            //return (is_dir($absolutePath.DIRECTORY_SEPARATOR.$value.DIRECTORY_SEPARATOR) && boolval($onlyFiles));
            if(is_dir($absolutePath.DIRECTORY_SEPARATOR.$value.DIRECTORY_SEPARATOR) && boolval($onlyFiles)){
                //return '1';
                $folderContents[] = array('name'=>$value,'type'=>'folder','path'=>$directory.DIRECTORY_SEPARATOR.$value);
                
            }
            
            if(is_file($absolutePath.$value) && ! boolval($onlyFolders)){
                
                $folderContents[] = array('name'=>$value,'type'=>'file','path'=>$directory.DIRECTORY_SEPARATOR.$value);
            }

        }
    
       return $folderContents;
        
    }
    /*-----------------------------------------*/
    
}
