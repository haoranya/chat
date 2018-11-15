<?php
    namespace libs;
    use pdo;
    class DB {

        static $pdo = null;

        static $DB = null;

        function __construct(){

            $config = config('db');

            if($pdo==null){

                self::$pdo = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}",$config['user'],$config['pass']);

                self::$pdo->exec("set names utf-8");

            }

        }

        static function make(){

            if(self::$DB==null){

                self::$DB = new DB;

            }

            return self::$DB;

        }

        function prepare($sql){

            $psm = self::$pdo->prepare($sql);

            return $psm;

        }

        function exec($sql){

            $data = self::$pdo->exec($sql);

            if($data!==false){

                return true;

            }else{

                return false;

            }

        }

        function query($sql){

            $psm = self::$pdo->query($sql);

            return $psm;

        }

    }

?>