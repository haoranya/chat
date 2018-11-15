<?php
    // websocket服务器
    
      //引入文件

      require("../Workerman-master/Autoloader.php");

      use Workerman\Worker;

      //连接数据库

     //实例化worker对象
      $worker = new Worker("websocket://0.0.0.0:9999");//0.0.0.0表示每个IP都可以访问这个服务器，一太电脑有多个IP

    //设置进程个数

    $worker->count = 1;

    $users = [];//保存连接的用户名

    $message = [];//保存群聊的信息

    $connect = [];//保存连接的客户端

    $person =[];//保存私聊的信息
   
    $worker->onConnect = function( $connection ) {

        // 为了能够使用 $_GET 接收连接时的参数，我们需要在这里绑定一个 onWebSocketConnect

        // 的回调函数，然后在函数中就可以使用 $_GET 接收参数了

        $connection->onWebSocketConnect = function ($connection, $http_header) {

            global  $worker,$users,$message,$connect;

            // 把这个客户端保存到users数组

                $own_info = json_decode($_GET['own_info'],true);

                $connection->uname = $own_info['uname'];

                $connection->uid = $own_info['uid'];
              
                $users[$own_info['uid']]= $own_info['uname'];//保存连接者的名字

                $connect[$own_info['uid']]= $connection;//保存连接者的客户端

                foreach($worker->connections as $c){

                    $c->send(json_encode([

                        'type'=>'users',

                        'users'=>$users,

                    ]));

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

    $worker->onMessage = function($connection,$data){
        
        global  $worker,$message,$connect,$person;     
        
        $data_arr = explode(':',$data);
        
        if($data_arr[0]=='all'){
            
            $message[]=$data_arr[1];

         // 循环所有的客户端，给它们发消息
         foreach($worker->connections as $c)
         {
             $c->send(json_encode([
              'type'=>'message',
              'message'=>$message,
                       ]));
         }             

        }else{

            $code = (int)$data_arr[0];

            $person[$code][]=$data_arr[1];

            $connect[$code]->send(json_encode([
                'type'=>'person',
                'person'=>$person,
             ]));
                    
             $connection->send(json_encode([
                'type'=>'person',
                'person'=>$person,
             ]));
  
        }

    };

    //当有客户端断开连接的时候

    $worker->onClose = function($connection){
        //从用户表里面删除这个用户
        global $worker,$users;
    
        unset($users['name'][$connection->id]);

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