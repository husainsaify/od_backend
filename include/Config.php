<?php
//Include files
require_once "function.php";

//auto load all the required classes
spl_autoload_register(function($class){
   include_once "../class/".$class.".php";
});

define("WHIZAPI_KEY","me8zpw7vg3r39krvoko9uizu");
define("WHIZAPI_URL","https://www.whizapi.com/custom-api/ca1006/send-transactionalsms");

//Set Database connection
Db::getConnection();