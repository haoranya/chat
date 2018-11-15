<?php
    namespace libs;
    use pdo;
    //数据库类
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
        //实例化唯一对象，减少资源浪费
        static function make(){

            if(self::$DB==null){

                self::$DB = new DB;

            }

            return self::$DB;

        }
        //预定义方法
        function prepare($sql){

            $psm = self::$pdo->prepare($sql);

            return $psm;

        }
        //php 操作数据库增删改的基础方法
        function exec($sql){

            $data = self::$pdo->exec($sql);

            if($data!==false){

                return true;

            }else{

                return false;

            }

        }
        //单独执行查询的sql方法
        function query($sql){

            $psm = self::$pdo->query($sql);

            return $psm;

        }

    }

?>