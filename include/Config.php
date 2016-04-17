<?php
//Include files
require_once "function.php";

//auto load all the required classes
spl_autoload_register(function($class){
   include_once "../class/".$class.".php";
});

//Set Database connection
Db::getConnection();