<?php
namespace Src\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Src\Common\Environment;
use Src\Routes\Requests;

class Api extends Requests
{
    function __construct($dir)
    {
        $this->loadEnv($dir);
        $this->setHeaders();
        $this->Router();
    }

    public static function Message($message,$status)
    {
        $response = [
            'code' => $status,
            'data' => $message
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

    public static function loadEnv($dir)
    {
        if (file_exists($dir.'/.env')) {
            $lines = file($dir.'/.env');
            foreach ($lines as $line) {
                putenv(trim($line));
            }
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
                $decoded = JWT::decode($token, new Key(getenv('API_KEY'), 'HS256'));
                return $decoded;
            } catch (\Exception $e) {
                throw new \Exception(json_encode(["error" => 'Token Invalido']), 1);
            }
        }
        return false;
    }
    public static function setHeaders()
    {
        $headers = [
            'Content-Type' => 'application/json;charset=utf-8',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => '*',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Credentials' => 'true',
        ];
        foreach ($headers as $headerType => $headerValue) {
            header($headerType.': '.$headerValue);
        }
    }
}