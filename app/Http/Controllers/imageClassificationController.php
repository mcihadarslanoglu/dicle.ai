<?php

namespace App\Http\Controllers;
use App\Models\imageClassificationModel;
use Illuminate\Http\Request;
use App\Models\fileTransferModel;
use Auth;
use ZipArchive;
config('projectConfigs.pathConfigs');
class imageClassificationController extends Controller
{
    
    public function uploadDataset()
    {
        

        
        $file = request()->file('file');
    
        $fileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $storagePath = __USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.'image-classification'.DIRECTORY_SEPARATOR.'datasets';

        try {

            if($fileExtension == 'zip'){
               
                $zipper = new ZipArchive;
                $res = $zipper->open($file->getPathName());
                
                if ($res == TRUE){
                    $zipper->extractTo($storagePath);
                }
               
                return $file->getPathName();
                
            }
            

        } catch (Exception $th) {


            return $th;
        }
       
        
       // $file->move(__USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.'image-classification'.DIRECTORY_SEPARATOR.'datasets',$fileName);
        
    
        
    }
    
    

}
