<?php
namespace Src\Core;

use \PDO;
use \PDOException;


final class DBConnection
{
    private const DRIVER = "mysql";
    private const HOST = "localhost";
    private const DB = "api";
    private const DBUSER = "porfiro";
    private const DBPASS = "52566ojn";
    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];
    
    private static ?PDO $instance;

    private function __construct()
    {
        /*
         * Do nothing
         */
    }
    private function __clone()
    {
        /*
         * Do nothing
         */
    }
    private function __wakeup()
    {
        /*
         * Do nothing
         */
    }
    public static function getInstance(): PDO
    {
        /**
         * If the instance is not created, create it
         */
        if(!isset(self::$instance)){
            try{
                self::$instance = new PDO(
                    self::DRIVER.":host=".self::HOST.";dbname=".self::DB,
                    self::DBUSER,
                    self::DBPASS,
                    self::OPTIONS
                );
               self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
           }catch(PDOException $e){
               throw new \Exception($e->getMessage());
           }
        }
        /*
         * Return the instance
         */
        return self::$instance;
    }
}