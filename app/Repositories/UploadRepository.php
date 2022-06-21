<?php


namespace App\Repositories;


use http\Env\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Resource_;

class UploadRepository
{
    /**
     * upload files
     * @param  $request the file request
     * @param  $file the file requested
     * @param  $type the file type
     * @param  $path the path of the file
     * @return $file_name the file name
     */
   /* public function upload($request,$file,$type,$path){
        if($request->hasFile($file)) {
            $file_data = $request->file($file);
            //generating unique file name;
            $file_name = $type.'_'.time().'.'.$request->file($file)->getClientOriginalExtension();
            $file_data->move(public_path('/'.$path),$file_name);
        }
        return asset('/'.$path.'/'.$file_name);
    }*/

    public function upload($request,$file,$type,$path){

        $file_data = base64_decode($request->input($file));
        $safeName = $type.'_'.time().'.'.'png';
        $destinationPath = public_path() .'/'. $path;
        file_put_contents($destinationPath.'/'.$safeName, $file_data);
        return asset('/'.$path.'/'.$safeName);

    }
}
