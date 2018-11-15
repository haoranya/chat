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

    }



?>