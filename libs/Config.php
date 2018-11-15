<?php
    //定义加载配置的函数
    function config($name){

        $config = require(ROOT."Config.php");

        return $config[$name];

    }

?>