<?php

namespace Src\Core;

class Environment
{
    /**
     * Método responsavel por carregar as variaveis de ambiente
     * @param string
     */
    public static function loadEnv($dir)
    {
        if (!file_exists($dir.'/.env')) {
            return false;
        }   
        $lines = file($dir.'/.env');
        foreach ($lines as $line) {
            putenv(trim($line));
        }  
    }
}