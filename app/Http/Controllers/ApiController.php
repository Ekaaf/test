<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use App\Userid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function getUserID(){
        $max = Userid::max('id');
        if(is_null($max)){
            $max = 0;
        }

        $result = DB::transaction(function() use ($max) {
            $userid = new Userid();
            $userid->id = $max+1;
            $userid->userid = str_pad($userid->id,12,"0",STR_PAD_LEFT);
            
            try
            {
                $userid->save();
                $result['code']='200';
                $result['success']= true;   
                $result['data']= $userid->userid;   
                return $result;
            }
            catch (\PDOException $e)
            {
                $result['code']='404';
                $result['success']= false;   
                $result['message']= 'Could not get userId. Please try again later.';   
                return $result;
            }
        });

        return response()->json($result);
        
    }

    public function saveFile(Request $request){
        // dd($request->getHttpHost());
        // dd($request->server);
        $userId = $request->input('userId');
        $dataFile = $request->file('dataFile');
        $fileType = $dataFile->getClientOriginalExtension();;
        $validUserid = Userid::where('userid',$userId)->value('userid');
        if(isset($validUserid) && isset($dataFile) && $fileType=='csv'){
            try{
                $filename = (string)date("Ymd").'_'.(string)date("His").'_'.(string)$userId.'.csv';
                $path = $request->file('dataFile')->storeAs('files/'.date("Ymd"),$filename);
                $result['code'] = 200;
                $result['success'] = true;
                $result['message'] = 'File Uploaded successfully.';
                return $result;
            }
            catch(\Exception $e) {
                $result['code'] = 404;
                $result['success'] = false;
                $result['message'] = 'File could not be uploaded. Please try again later.';
                return $result;
            }
        }
        else{
            $result['code'] = 404;
            $result['success'] = false;
            $result['message'] = 'Invalid input data.';
        }


        return response()->json($result);
       
    }
}
