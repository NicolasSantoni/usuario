<?php
class Conexao {
    public static $instance;

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance =new PDO(SGBD.":host=".HOST_DB.";dbname=".DB."",USER_DB,PASS_DB);
        }
        return  self::$instance;
    }
}