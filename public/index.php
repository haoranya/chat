<?php   
    //定义根目录
    define("ROOT",__dir__."/../"); 
    //引入视图的自动加载
    require(ROOT."libs/View.php");
    //基本设置的加载
    require(ROOT."libs\Config.php");
    //判断接收控制器参数的方式

    if(php_sapi_name()=="cli"){

        $_C = ucfirst($argv[1])."Controller";

        $_A = $argv[2];

    }else{

        if(isset($_SERVER['PATH_INFO'])){

            $arr = explode('/',$_SERVER['PATH_INFO']);

            $_C = ucfirst($arr[1])."Controller";

            $_A = $arr[2];

        }else{

            $_C = "LoginController";

            $_A = "login";

        }
    }

     //自动加载

     function autoload($classname){

        $path = str_replace("\\","/",$classname).".php";
     
        require(ROOT.$path);

    }

    //注册

    spl_autoload_register("autoload");

    //拼写控制器名字

    $controller = "Controllers\\".$_C;

    $obj = new $controller;

    $obj->$_A();

?>