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
        //注册时对用户名的唯一性的检测  ajax
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
        //注册时对电话号码唯一性的验证  ajax
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
        //完成注册，更新数据库
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