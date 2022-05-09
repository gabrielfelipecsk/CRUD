<?php
namespace Src\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Api
{
    private const SECRET_KEY = "S3cr3tK3y";
    private const LOGIN_FAIL = "Login ou senha incorretos";

    public static function Message($message, $status)
    {
        $response = [
            'status' => $status,
            'message' => $message
        ];
        return json_encode($response, true);
    }
    public static function getBody() : array
    {
        $body = file_get_contents('php://input');
        if(isset($body) && $body != null && $body != ""){
            return json_decode($body, true);
        }
        return false;
    }
    public static function getToken()
    {
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
            $token = $headers['Authorization'];
            $token = str_replace("Bearer ", "", $token);
            try {
                $decoded = JWT::decode($token, new Key(self::SECRET_KEY, 'HS256'));
                return $decoded;
            } catch (\Exception $e) {
                throw new \Exception("Token inválido");
                header("HTTP/1.1 401 Unauthorized");
                exit;
            }
        }
        return false;
    }
}