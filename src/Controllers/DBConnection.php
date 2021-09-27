<?php
namespace Src\Controllers;

use \PDO;
use \PDOException;

class DBConnection{
    private const HOST = "localhost";
    private const DB = "exemplo";
    private const DBUSER = "root";
    private const DBPASS = "";
    
    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    private static $instance;

    /**
     * @return PDO
     */

    public static function getInstance(): PDO
    {
        if(empty(self::$instance)){
            try{
                self::$instance = new PDO(
                    "mysql:host=".self::HOST.";dbname=".self::DB,
                    self::DBUSER,
                    self::DBPASS,
                    self::OPTIONS
                );
               self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
           }catch(PDOException $e){
               die("Falha na conexão com banco de dados: ".$e->getMessage());
           }
        }

        return self::$instance;
    }
    final private function __construct(){

    }
    final private function __clone()
    {
        
    }
}