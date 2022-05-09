<?php
namespace Src\Controllers;

use Src\Controllers\Api;
use Src\Core\DBConnection;
use Src\Controllers\Auth;
use \PDO;


class Route extends Api
{
    public static function dashboard()
    {
        $token = Api::getToken();
        if(!$token){
            echo Api::Message("Token not provided", 'error');
            header("HTTP/1.1 401 Unauthorized");
            return;
        }
    }
    public static function profile() 
    {
        $check = Auth::check();
        return $check;
    }
    public static function profileUpdate()
    {
        $body = self::getBody();
        
        if(empty($body) || !isset($body) || $body == null || $body == ""){
            echo self::Message("Empty body", 'error');
            header("HTTP/1.1 400 Bad Request");
            return;
        }
        if(!isset($body['name']) or !isset($body['email']) or !isset($body['password'])){
            echo self::Message("Missing fields", 'error');
            header("HTTP/1.1 400 Bad Request");
            return;
        }
        

    }

}