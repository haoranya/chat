<?php
    // websocket服务器
    
      //引入文件

      require("../Workerman-master/Autoloader.php");

      use Workerman\Worker;

     //实例化worker对象
      $worker = new Worker("websocket://0.0.0.0:9999");//0.0.0.0表示每个IP都可以访问这个服务器，一太电脑有多个IP

    //设置进程个数

    $worker->count = 1;

    $users = [];//保存连接的用户名

    $message = [];//保存群聊的信息

    $connect = [];//保存连接的客户端

    $person =[];//保存私聊的信息

    $uid_arr = [];//保存所有连接者的uid
   
    $worker->onConnect = function( $connection ) {

     



        // 为了能够使用 $_GET 接收连接时的参数，我们需要在这里绑定一个 onWebSocketConnect

        // 的回调函数，然后在函数中就可以使用 $_GET 接收参数了

        $connection->onWebSocketConnect = function ($connection, $http_header) {

            global  $worker,$users,$message,$connect,$uid_arr;

                $own_info = json_decode($_GET['own_info'],true);//接收客户端连接时传过来数据

                $connection->uname = $own_info['uname'];//向客户端添加数据

                $connection->uid = $own_info['uid'];//向客户端添加数据
              
                $users[$own_info['uid']]= $own_info['uname'];//保存连接者的名字

                $connect[$own_info['uid']]= $connection;//保存连接者的客户端
                if(in_array($connection->uid,$uid_arr)){

                }else{

                    $uid_arr[]=$connection->uid;//保存连接者的id

                }
                

                //连接成功,向所有的上线玩家发送玩家信息
                foreach($worker->connections as $c){

                    $c->send(json_encode([

                        'type'=>'users',

                        'users'=>$users,

                    ]));

                    $c->send(json_encode([
                        'type'=>'uid_arr',
                        'uid_arr'=>$uid_arr,
                      ]));
                    //初始化群聊信息
                    foreach($worker->connections as $c)
                    {
                        $c->send(json_encode([
                         'type'=>'message',
                         'title'=>$connection->uname,
                         'message'=>$message,
                        ]));
           
                    }   

                }

          };
    };
    //接收客户端的信息,并进行响应
    $worker->onMessage = function($connection,$data){
        
        global  $worker,$message,$connect,$person;     
        
        $data_arr = explode(':',$data);//分解数据
        //判断当前的而用户时群发还是私发
        if($data_arr[0]=='all'){
            
            $message[$connection->uid][]=$data_arr[1];

           

         // 循环所有的客户端，响应消息
         foreach($worker->connections as $c)
         {
             $c->send(json_encode([
              'type'=>'message',
              'message'=>$message,
            ]));

           
         }                         

        }else{
            //私聊
            $code = (int)$data_arr[0];//获取私聊对象的uid
            
            $person[$connection->uid.$code][]=$data_arr[1];//存放私聊的消息
            //向聊天对象发消息
            $connect[$code]->send(json_encode([
                'type'=>'person',
                'person'=>$person,
             ]));
            //响应自己的客户端
             $connection->send(json_encode([
                'type'=>'person',
                'person'=>$person,
             ]));
  
        }

    };

    //当有客户端断开连接的时候

    $worker->onClose = function($connection){
        
        global $worker,$users;
         // 根据用户id从数组中删除
       unset($users[$connection->uid]);
         // 循环所有的客户端，给它们发消息
    foreach($worker->connections as $c)
       
       {
        $c->send(json_encode([
            'type'=>'users',
            'users'=>$users
          ]));
       } 

    };

    //服务器的启动运行

    Worker::runAll();

?>