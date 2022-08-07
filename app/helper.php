<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

if(!function_exists("removeWhiteSpace")){

    function removeWhiteSpace($string){

        return strtolower(str_replace(" ", "-", $string));
    }
  
}
function __getAccess($id,$url){
    $data = DB::table('users_modul')
    ->join('submoduls', 'users_modul.umod_submodul_id', '=', 'submoduls.submodul_id')
    ->select('*')
    ->where('umod_users_id',$id)
    ->where('submoduls.submodul_slug',$url)
    ->get();
    
    if($data->count() > 0){
        return true;
    }else{
        return false;
    }
}

