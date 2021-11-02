<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Auth;
//use App\Models\buildTreeFromDirectory3;

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
     * $folderPath: klasörün oluşturulacağı yerin tam yolu.
     * $mode: Windowsda bir etkisi olmayan fakat linux sunucularda klasör erişim izni. Varsayılan olarak 0777 yani bütün izinler tam yetkide.
     * $recursive: Eğer yol olarak verilen klasörlerden herhangi biri eksik ise sistem onu da olulstursun mu oluşturmasın mı.
     * 
     */

    public static function createFolder($folderPath, $mode = 0777,$recursive = False){

        if(is_dir($folderPath)){
            return "HKK1";
        }
        else {
            mkdir($pathname = $folderPath, $mode = $mode, $recursive = $recursive);
            return True;
        }
    }
    /*-----------------------------------------*/

    public static function deleteDir($directory){

        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    
        return 0;
    }


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
     * 
     *                  ↑
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
    public static function listFolder($directory, $onlyFolders = TRUE, $onlyFiles = FALSE){
        
        $absolutePath = __USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.$directory;
        
        $folderContentsTemp = scandir(__USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.$directory);
        $folderContentsTemp = array_diff($folderContentsTemp,['..','.']);
        
        $folderContents = array();
        
        foreach ($folderContentsTemp as $key => $value) {
            
        
            if(is_dir($absolutePath.DIRECTORY_SEPARATOR.$value.DIRECTORY_SEPARATOR) && !boolval($onlyFiles)){
                
                $folderContents[] = array('name'=>$value,'type'=>'folder','path'=>$directory.DIRECTORY_SEPARATOR.$value);
                
            }
            
            if(is_file($absolutePath.$value) && ! boolval($onlyFolders)){
                $folderContents[] = array('name'=>$value,'type'=>'file','path'=>$directory.DIRECTORY_SEPARATOR.$value);
            }

        }
    
       return (json_encode($folderContents));
        
    }
    /*-----------------------------------------*/
    
}
