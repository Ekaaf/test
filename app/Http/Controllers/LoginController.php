<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use App\Userid;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Session;
use Response;
use ZipArchive;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use File;
use Redirect;

class LoginController extends Controller
{
    public function login(){
    	// Session::flush();
     //    // Log out
     //    Auth::logout();
        return View('login');
        
    }

    public function postLogin(Request $request){
    	$username = $request->input('username');
    	$password = $request->input('password');


    	if (Auth::attempt(['username' => $username, 'password' => $password])) {
    		return redirect('dashboard');
        }
        else{
            $user = User::where('username',$username)->value('username');
            if($user){
                return Redirect::back()->withInput($request->input())->with('password', 'パスワードが不正です。入力し直して下さい。');
            }
            else{
                return Redirect::back()->withInput($request->input())->with('username', 'IDが不正です。入力し直して下さい。')->with('password', 'パスワードが不正です。入力し直して下さい。');
            }
        }
    }

    public function dashboard(){
        return View('dashboard');
        
    }

    public function downloadFile(Request $request){
    	$startDate = str_replace("/","-",$request->input('startDate'));
    	$endDate = str_replace("/","-",$request->input('endDate'));
    	// dd($startDate);
    	if(empty($startDate) || empty($endDate)){
    		return Redirect::back()->withInput($request->input())->with('error', '期間が不正です。入力し直して下さい。');
    	}
    	$allFiles=[];

    	$period = CarbonPeriod::create($startDate, $endDate);
    	$dates = $period->toArray();
    	foreach ($dates as $date) {
    		$folders[] = date('Ymd', strtotime($date));
    	}
    	foreach ($folders as $folder) {
    		$folderPath = storage_path().'/'.'app/files/'.$folder;
    		if(is_dir($folderPath)){
    			$directory = '/files/'.$folder;
    			$files = Storage::files($directory);
    			$allFiles = array_merge($allFiles,$files);
    		}
    	}
    	
        if(count($allFiles)==0){
            return Redirect::back()->with('nofile', 'No file available within the given date.');
        }
		
		$public_dir=public_path();
    	$zipFileName = 'AllDocuments.zip';
    	File::delete($public_dir.'/'.$zipFileName);
    	$zip = new ZipArchive;
        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
        	foreach ($allFiles as $file) {
        		$path = storage_path().'/'.'app/'.$file;
        		$explodedPath = explode('/', $path);
        		$fileName = $explodedPath[count($explodedPath)-1];
		    	$zip->addFile($path, $fileName);
        	}
        	
            $zip->close();
        }

        $filetopath=$public_dir.'/'.$zipFileName;
        if(file_exists($filetopath)){
            return response()->download($filetopath,$zipFileName);
        }
    	
	}

    public function logout(){
        Session::flush();
        // Log out
        Auth::logout();
        return redirect()->intended('login');
    }

    
}
