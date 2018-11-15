<?php
    namespace controllers;
    use libs\DB;//引入连接数据库的文件
    class ChatController{

        public $db=null;
        //构造函数连接数据库
        function __construct(){

            $this->db = DB::make();

        }
        //显示聊天页面
        function chat(){

            $uid = $_COOKIE['uid'];//获取登陆着的uid

            $own =  $this->db->prepare('select * from users where uid = ?');

            $own->execute([$uid]);

            $own_info = $own->fetch();//查询登陆者的信息
            
            $psm = $this->db->prepare('select * from users where uid != ?');

            $psm->execute([$uid]);

            $users = $psm->fetchAll(\PDO::FETCH_ASSOC);//查询所有用户信息
        
            view("chat.chat",['users'=>$users,'own_info'=>json_encode($own_info)]);//加载视图

        }
        //保存私聊信息到数据库
        function save_single_chat(){

            //由于axios传递的数据时json数据所以不可以使用$_GTE,$_POST接收
            
            $post = file_get_contents("php://input");

            $_POST = json_decode($post,TRUE);//把接收到的json数据转换为数组;

            $self_obj = $_POST['self_obj'];

            $uname = $_POST['uname'];

            $content = $_POST['content'];

            $data = $this->db->exec("insert into single_chat(uname,self_obj,content) values('{$uname}',{$self_obj},'{$content}')");

            if($data){

                echo  1;

            }else{
                echo  0;

            }

        }

        //保存群聊信息到数据库

        function save_all_chat(){

             //由于axios传递的数据时json数据所以不可以使用$_GTE,$_POST接收
            
             $post = file_get_contents("php://input");

             $_POST = json_decode($post,TRUE);//把接收到的json数据转换为数组;
 
             $uid = $_POST['uid'];
 
             $uname = $_POST['uname'];
 
             $content = $_POST['content'];
 
             $data = $this->db->exec("insert into all_chat(uname,uid,content) values('{$uname}',{$uid},'{$content}')");
 
             if($data){
 
                 echo  1;
 
             }else{
                 echo  0;
 
             }

        }

        //初始化私聊界面的记录 

        function before_chat(){

               //由于axios传递的数据时json数据所以不可以使用$_GTE,$_POST接收
            
               $post = file_get_contents("php://input");

               $_POST = json_decode($post,TRUE);//把接收到的json数据转换为数组;
   
               $self_obj = $_POST['self_obj'];

               $psm = $this->db->prepare("select * from single_chat where self_obj=?");

               $psm->execute([$self_obj]);

               $chat_data = $psm->fetchAll(\PDO::FETCH_ASSOC);

               echo json_encode($chat_data);
   
        }

    }



?>