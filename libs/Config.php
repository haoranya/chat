<?php

    function config($name){

        $config = require(ROOT."Config.php");

        return $config[$name];

    }

?>