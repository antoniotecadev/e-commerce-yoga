<?php

Class Conexao{

    private static $conect;

    public static function getConnect(){
         try{
            if (self::$conect == null) { 
               self::$conect = new \PDO('mysql:host=localhost;dbname=e-commerce-yoga;charset=utf8', 'root','');
            }
            return self::$conect;
         }catch(PDOException $erro){
            echo $erro->getMessage();
         }
    }
    
}

