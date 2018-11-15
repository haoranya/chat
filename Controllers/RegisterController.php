<?php
    namespace controllers;
    use   libs\DB;
    class RegisterController{

        public $db=null;

        function __construct(){

            $this->db = DB::make();

        }

        function register(){

            view('register.register');

        }

        function check_uname(){
            
            $uname = $_GET['uname'];

            $psm = $this->db->prepare('select uname from users where uname=?');

            $psm->execute([$uname]);

            $uname_info = $psm->fetch();

            // var_dump($uname_info);

            if($uname_info){

               echo  1;

            }else{

               echo   0;

            }

        }

        function check_tel_num(){

            $tel_num = $_GET['tel_num'];

            $psm = $this->db->prepare('select uname from users where tel_num=?');

            $psm->execute([$tel_num]);

            $tel_num_info = $psm->fetch();
          
            if($tel_num_info){

                echo 1;

            }else{

                echo 0;

            }

        }

        function doregister(){

            $uname = $_POST['uname'];

            $password = md5($_POST['password']);

            $tel_num = $_POST['tel_num'];

            $psm = $this->db->prepare("insert into users(uname,password,tel_num) values(?,?,?)");
    
            $data = $psm->execute([$uname,$password,$tel_num]);

            if($data!==false){

                echo "<script>alert('注册成功！！！');location.href='/login/login';</script>";

            }
        }

    }


?>