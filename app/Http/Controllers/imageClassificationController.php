<?php

namespace App\Http\Controllers;
use App\Models\imageClassificationModel;
use Illuminate\Http\Request;
use App\Models\fileTransferModel;
use App\Models\checkerModel;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use App\Models\userFolderModel;


use Auth;
use ZipArchive;
config('projectConfigs.pathConfigs');
class imageClassificationController extends Controller
{
    /*-----------------------------------------*/
    /**
     *
     * Kullanıcıların sisteme yüklemek istedikleri verisetleri burada yüklenir ve uygun formata getirilir. 
     * PARAMETRELER
     * file: Sisteme yüklenecek olan dosya.
     * path: Dosyanın yükleneceği yer.
     * 
     * return true/th
     * th: Eğer dosya sisteme yüklenirken bir sorun oluşursa oluşan sorunu tanımlayan bir string değeri.
     */
    public function uploadDataset()
    {
        //header('Content-Type: application/json',true);   
        header("Content-Type: application/json", true);
        //return var_dump(request()->header('data'));
        return var_dump(request()->all());
        
        
        
        //return 'test';
        return var_dump(request()->all());
        $file = request()->all();
        
        return var_dump($file);//.'test32';
        //return $file[0]['name'];
        $fileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $storagePath = __USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.'image-classification'.DIRECTORY_SEPARATOR.'datasets';
        return $fileName;
        try {

            if($fileExtension == 'zip'){
               
                $zipper = new ZipArchive;
                $res = $zipper->open($file->getPathName());
                
                if ($res == TRUE){
                    $zipper->extractTo($storagePath);
                }
               
                //return $file->getPathName();
                return true;
            }
            

        } catch (Exception $th) {


            return $th;
        }
       
        
       // $file->move(__USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.'image-classification'.DIRECTORY_SEPARATOR.'datasets',$fileName);
        
    
        
    }
    /*-----------------------------------------*/

    /*-----------------------------------------*/
    /**
     * 
     * Kullanıcılar sistemde bulunan hernagi bir verisetini eğitmek istediklerinde bu fonksiyon çalışır.
     * 
     * PARAMETRELER
     * 
     * $parameters = "{'dataset':{'path':r'C:\\xampp\\htdocs\\dicle.ai\\users\\f40b8a370870a98a39097c3faadfd7117ad7f2a7eec81455a54638788c405180\\image-classification\\datasets\\dataset1','color_mode':'gray','validation_split':0.1,'shuffle':True},
     * 'augmentation':{'reshape':{'new_height':28, 'new_width':28, 'interpolation':'linear'},'zoom':{'zoomFactor':0.2, 'zoomDirectories':['in'],'interpolation':'cubic'},'rotate':{'angle':45,'rotateDirectories':['left','right']}},
     * 'trainingParameters':{'epochs':3,'batch_size':1,'class_mode':'categorical','metrics':{'name':'CategoricalAccuracy'},'optimizer':{'learning_rate':0.001, 'name':'Adadelta'},'loss':{'name':'CategoricalCrossentropy'},'class_mode':{'name':'CategoricalCrossentropy'}},
     * 'save':{'path':r'C:\xampp\htdocs\dicle.ai\users\f40b8a370870a98a39097c3faadfd7117ad7f2a7eec81455a54638788c405180\image-classification\trained-datasets','saveName':'dataset1'}}";
     * 
     * $modelName = 'lenet';
     */
    function train(){
        

        //$parameters = json_encode(request()->all());
        $parameters = request()->all();
        //return $parameters;
        //$parameters['dataset'] = array('path' => __USERFOLDERS__.Auth::user()['foldername'].DIRECTORY_SEPARATOR.'image-classification'.DIRECTORY_SEPARATOR.'datasets'.DIRECTORY_SEPARATOR.);
        $parameters['save']['path'] = __USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.'image-classification'.DIRECTORY_SEPARATOR.'trained-datasets';//.DIRECTORY_SEPARATOR.$parameters['save']['name'];
        $parameters['dataset']['path'] = __USERFOLDERS__.DIRECTORY_SEPARATOR.Auth::user()['foldername'].DIRECTORY_SEPARATOR.'image-classification'.DIRECTORY_SEPARATOR.'datasets'.DIRECTORY_SEPARATOR.$parameters['dataset']['path'];
        //return $parameters;
        #$modelName = $request->input('modelName');
        $user = Auth::user();

        //return $parameters;
        
        //return $parameters['trainingParameters']['model'];
        $checkUserPermission = checkerModel::checkUserPermission($user,$parameters['trainingParameters']['model']);//,$parameters['model'] 
        
        if($checkUserPermission){
            $checkStatus = checkerModel::checkStatus($parameters['trainingParameters']['model']);
            
            if($checkStatus){
                
                $checkUsage = checkerModel::checkUsagePerDay($user,$parameters['trainingParameters']['model']);
                
                if($checkUsage){
                    if($checkUsage == 1){
                        $timestamp = time();
                        //DB::table('users')->where('email',Auth::user()->email)->update(['usage_count' => 1]);
                        DB::table('users')->where('email',Auth::user()->email)->update(['usage_count' => 1]);
                        DB::table('users')->where('email',Auth::user()->email)->update(['last_train_time' => date('Y-m-d H:i:s',time())]);
                    }
                    
                    $command = escapeshellcmd("python ".__ROOTPATH__.DIRECTORY_SEPARATOR."pythonscripts".DIRECTORY_SEPARATOR."image-classification\\train.py -p ".base64_encode(json_encode($parameters))." -m ".$parameters['trainingParameters']['model']);
                    //$command = 'python3 '.__ROOTPATH__.DIRECTORY_SEPARATOR.'python-scripts'.DIRECTORY_SEPARATOR.'image-classification\test.py -p '.json_encode($parameters).' -m '.$parameters['trainingParameters']['model'];
                    //$command = 'python  C:\\xampp\\htdocs\\dicle.ai\\python-scripts\\image-classification\\test.py';
                    //return $command;
                    return "python ".__ROOTPATH__.DIRECTORY_SEPARATOR."pythonscripts".DIRECTORY_SEPARATOR."image-classification\\train.py -p ".base64_encode(json_encode($parameters))." -m ".$parameters['trainingParameters']['model'];
                    $output = exec($command);
                    return $output;

                    //return $parameters;

                    //$process = new Process(['python', __ROOTPATH__.DIRECTORY_SEPARATOR.'pythonscripts'.DIRECTORY_SEPARATOR.'image-classification\train.py', '-p '.json_encode($parameters),'-m '.$parameters['trainingParameters']['model']]);
                    //$process = new Process(['python', 'C:\xampp\htdocs\dicle.ai\pythonscripts\image-classification\test.py']);
                    //$process = new Process(['ls', '-lsa']);
                    //return var_dump($process);
                    //$process->run();
                    //return var_dump($process);
                    //return $process->getOutput();
                }     
                 return 'Günlük kullanım hakkınız kalmamıştır.';
                
            }
            return 'Bu ağ şu an kullanımda değil';
        }

        return 'Bu ağı kullanmak için yeterli izniniz yok';
        
    
    }
    /*-----------------------------------------*/


    public function trainView()
    {   
        $directory = 'image-classification'.DIRECTORY_SEPARATOR.'datasets';#= __ROOTPATH__.DIRECTORY_SEPARATOR.'users'.Auth::user()['foldername'].DIRECTORY_SEPARATOR.'image-classification'.DIRECTORY_SEPARATOR.'datasets';
        $datasets = userFolderModel::listFolder($directory);
        $losses = DB::table('components')->where(['category'=>'loss','status'=>1])->get();
        $optimizers = DB::table('components')->where(['category' => 'optimizer', 'status' => 1])->get();
        $metrics = DB::table('components')->where(['category' => 'metric', 'status' => 1])->get();
        $models = DB::table('components')->where(['category' => 'model', 'status' => 1])->get();
        //return var_dump($models);
        $userRole=  Auth::user()->role;
        //return (in_array($userRole, explode(';',$models[0]->permissions)));
        //return var_dump($userRole, $models);
        #return var_dump($optimizers);
        #return json_decode(str_replace(array('[',']'),'',$datasets));#view('classificationTrain');
        #return $datasets[0]['name'];
        return view('classificationTrain', ['datasets'=>$datasets,'optimizers'=>$optimizers, 'losses'=>$losses,'metrics'=>$metrics,'models'=>$models,'userRole'=>Auth::user()->role]);
    }
    
    
    

}
