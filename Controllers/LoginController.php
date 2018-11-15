<?php

    namespace controllers;

    use libs\DB;

    class LoginController{

        public $db=null;

        function __construct(){

            $this->db = DB::make();

        }
         //登录视图的显示
         function login(){

            $uname = $_COOKIE['uname'];

            $password = $_COOKIE['password'];
            //判断是否是自动登录
            if($uname!=null&&$password!=null){

                $psm = $this->db->prepare('select * from users where uname=? and password=?');

                $psm->execute([$uname,$password]);

                $data = $psm->fetch(); 
                
                if($data){

                    header("Location:/user/userlist");

                }

            }

            view("login.login");

         }
         //完成登陆，跳转的操作
         function dologin(){ 

            $uname = $_POST['uname'];

            $password = md5($_POST['password']);

            $psm = $this->db->prepare('select * from users where uname=? and password=?');

            $psm->execute([$uname,$password]);
            
            $data = $psm->fetch();

            $seven_day = 60*60*24*7;

            if($data){

                setcookie('uname',$uname,time() + 99 * 365 * 24 * 3600,'/');
                //判断用户是否要记住密码
                if($_POST['remember']=='on'){
                   
                    setcookie('uname',$uname,time()+$seven_day,'/');

                    setcookie('password',$password,time()+$seven_day,'/');
                   
                };
                
                setcookie('uid',$data['uid'],time() + 99 * 365 * 24 * 3600,'/');
               
                header("Location:/user/userlist");

            }else{

                echo  "<script>alert('密码错误!!!');location.href='/login/login';</script>";

            }
         }
         //安全退出登录
         function logout(){

            setcookie("uid",'',-1,'/');

            setcookie("password",'',-1,'/');
            
            setcookie("uname",'',-1,'/');//清空cookie

            header("Location:http:/login/login");

         }

    }



?>