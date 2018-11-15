<?php
    namespace controllers;
    use libs\DB;
    class ChatController{
        public $db=null;

        function __construct(){

            $this->db = DB::make();

        }
        function chat(){

            $uid = $_COOKIE['uid'];

            $own =  $this->db->prepare('select * from users where uid = ?');

            $own->execute([$uid]);

            $own_info = $own->fetch();
            
            $psm = $this->db->prepare('select * from users where uid != ?');

            $psm->execute([$uid]);

            $users = $psm->fetchAll(\PDO::FETCH_ASSOC);
        
            view("chat.chat",['users'=>$users,'own_info'=>json_encode($own_info)]);

        }

    }



?>