<?php
namespace Src\Controllers;

use Src\Core\DBConnection;
use \PDO;
use Firebase\JWT\JWT;
use Src\Controllers\Api;


class Auth extends Api
{

    /**
     * Método para fazer o login
     * @param Request $request
     * @return array
     */
    private const LOGIN_SUCCESS = "Login efetuado com sucesso";
    private const LOGIN_FAIL = "Login ou senha incorretos";
    private const SECRET_KEY = "S3cr3tK3y";

    public static function isEmail(string $email) : bool
    {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($email) {
            return true;
        }
        return false;
    }
    public static function isPassword(string $password, string $hash) : bool
    {
        if (password_verify($password, $hash)) {
            return true;
        }
        return false;
    }
    public static function consultUser(string $email) : array
    {
        $db = DBConnection::getInstance();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$user){
            echo self::Message(self::LOGIN_FAIL, 'error');
        }
        return $user;
    }

    public static function Login($data) 
    {         
        $data = self::getBody();
        if(empty($data) || !isset($data) || $data == null || $data == ""){
            echo self::Message(self::LOGIN_FAIL, 'error');
            exit;
        }
        if(!isset($data['email']) or !isset($data['password'])){
            echo self::Message(self::LOGIN_FAIL, 'error');
            exit;
        }
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($data['password'], double_encode: false);
        if (!self::isEmail($email)) {
            echo self::Message(self::LOGIN_FAIL, 'error');
            return false;
        }
        $user = self::consultUser($email);
        if (!self::isPassword($password, $user['password'])) {
            echo self::Message(self::LOGIN_FAIL, 'error');
            return false;
        }
        $payload = [
            'email' => $user['email'],
            'exp' => time() + (60 * 60 * 24 * 30)
        ];
        $jwt = JWT::encode($payload, self::SECRET_KEY, 'HS256');
        $response = [
            'status' => 'success',
            'message' => self::LOGIN_SUCCESS,
            'token' => $jwt
        ];
        echo json_encode($response, true);
        setcookie('jwt', $jwt, time() + (86400 * 30), "/");     
        return;
    }

    public static function check()
    {
        $token = Api::getToken();
        if(!$token){
            echo Api::Message("Token not provided", 'error');
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        $user = $token->email;
        $db = DBConnection::getInstance();

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $user, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$user){
            echo Api::Message("Usuário não encontrado", 'error');
            header("HTTP/1.1 401 Unauthorized");
            return false;
        }
        return $user;
    }


    public static function Logout()
    {
        setcookie('jwt', '', time() - 3600, "/");
        echo self::Message("Logout efetuado com sucesso", 'success');
        return;
    }
}