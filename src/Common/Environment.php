<?php
namespace Src\Common;

class Environment{
    
    /**
     * Método de Carregamento das váriaveis de ambiente
     *
     * @param string $dir Localização do Env
     * @return void
     */
    public static function load($dir){
        // Verificação se caminho do ENV Existe
        if(!file_exists($dir.'/.env')){
            return false;
        }
        //Definição das Variaveis
        $lines = file($dir.'/.env');
        foreach($lines as $line){
            putenv(trim($line));
        }
    }
}