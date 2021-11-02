<?php

namespace App\Http\Controllers;
use App\Models\userFolderModel;
use Illuminate\Http\Request;
use Auth;
config('projectConfigs.pathConfigs');
class userFolderController extends Controller
{



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
    function listFolder($directory,$onlyFolders = TRUE, $onlyFiles = FALSE){
        
        
        $directory = request('directory');
        $onlyFiles = request('onlyFiles');
        $onlyFolders = request($onlyFolders);
        
        //$directory = '\\image-classification';//--> test için burayı aktif et
        //$onlyFolders = TRUE; //--> test için burayı aktif et
        //$onlyFiles = TRUE; // test için burayı aktif et
        
        return userFolderModel::listFolder($directory, $onlyFolders,$onlyFiles );
        
    }
    /*-----------------------------------------*/

}
