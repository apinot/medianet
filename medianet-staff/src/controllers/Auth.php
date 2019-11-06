<?php


namespace medianet\controllers;


use medianet\models\User;

class Auth
{

    public function verifEmail($email){
        $user = User::where('email',$email)->get();
        if ($user == null){
            return true;
        }else{
            return false;
        }
    }
}