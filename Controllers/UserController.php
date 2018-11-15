<?php
    namespace controllers;

    use libs\DB;
   
    class UserController{

        public $db=null;

        function __construct(){

            $this->db = DB::make();

        }
        //加载用户列表视图
        function userlist(){
        
            $psm = $this->db->prepare("select * from users");

            $psm->execute([]);

            $data = $psm->fetchAll(\PDO::FETCH_ASSOC);

            view("users.users",['data'=>$data]);

        }

        function edit(){

           $uid =  $_GET['uid'];

           $psm = $this->db->prepare('select * from users where uid = ?');

           $psm->execute([$uid]);

           $user = $psm->fetch();

           view("users.edit_user",['user'=>$user]);//编辑用户

        }
        //编辑用户时对数据用户名唯一性的判断 ajax
        function check_uname(){
         
            $uname = $_GET['uname'];

            $uid = $_GET['uid'];

            $psm = $this->db->prepare('select uname from users where uname=? and uid!=?');

            $psm->execute([$uname,$uid]);

            $uname_info = $psm->fetch();

            if($uname_info){

               echo  1;

            }else{

               echo   0;

            }

        }
         //编辑用户时对数据电话号码唯一性的判断 ajax
        function check_tel_num(){

            $tel_num = $_GET['tel_num'];

            $uid = $_GET['uid'];

            $psm = $this->db->prepare('select tel_num from users where tel_num=? and uid!=?');

            $psm->execute([$tel_num,$uid]);

            $tel_num_info = $psm->fetch();
          
            if($tel_num_info){

                echo 1;

            }else{

                echo 0;

            }

        }
        //执行更新数据库的操作
        function update(){

            $old_password = md5($_POST['old_password']);

            $new_password = md5($_POST['new_password']);

            $uname = $_POST['uname'];

            $tel_num = $_POST['tel_num'];

            $uid = $_GET['uid'];

            $psm = $this->db->prepare("select * from users where uname=? and password=?");

            $psm->execute([$uname,$old_password]);

            $data = $psm->fetch();

            if($data){

                $result = $this->db->exec("update users set uname='{$uname}',tel_num='{$tel_num}',password='{$new_password}' where uid={$uid}");
     
                if($result){
    
                  echo  "<script>if(confirm('修改成功,要继续修改吗?')){location.href='/user/edit?uid={$uid}'}else{location.href='/user/userlist'}</script>";
    
                }

            }else{

                echo  "<script>alert('旧密码不正确！！!');location.href='/user/edit?uid={$uid}';</script>";

            }

        }
        //删除一个用户
        function delete(){

            $uid = $_GET['uid'];

            $cookie_uid = $_COOKIE['uid'];       

            $result = $this->db->exec("delete  from users where uid = {$uid}");

            if($result){

                if($uid==$cookie_uid){

                    setcookie("uid",'',-1,'/');

                    setcookie("password",'',-1,'/');

                    setcookie("uname",'',-1,'/');//清空cookie

                    echo  "<script>alert('您删除的是当前登陆着,请重新登录！');location.href='/login/login';</script>";

                }else{

                    echo  "<script>alert('删除成功?');location.href='/user/userlist';</script>";

                }

               

            }

        }

    }

?>