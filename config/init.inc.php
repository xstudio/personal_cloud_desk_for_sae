<?php
    define("PATH", str_replace('\\', '/', dirname(dirname(__FILE__))));
    include PATH.'/libs/Smarty.class.php';

    $smarty = new Smarty();  

   
    $path="saemc://coms";//使用MC Wrapper
    mkdir($path);
    
    $smarty->template_dir = PATH."/tpls"; 
    $smarty->compile_dir = $path; //设置编译目录
    
