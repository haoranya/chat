<?php
   
        function view($file,$data=[]){

            //转换关联数组为变量

            extract($data);

            //转换文件的二级目录个文件名组合的字符串，来达到require引入

            $arr = explode(".",$file);

            require(ROOT."Views/".$arr[0]."/".$arr[1].".html");

        }

?>