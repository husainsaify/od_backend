<?php
//Method to echo json
function json($json = array()){
    echo json_encode($json);
    exit();
}

//Method to validate $variable
function e($var){
    return trim(htmlentities($var,ENT_QUOTES,"UTF-8"));
}

//method to validate mobile number
function validate_mobile_number($mobile){
    if(preg_match('/^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1})?([0-9]{10})$/', $mobile,$matches)){
        return true;
    }
    return false;
}

/*
 * Function to check required parameters
 * return
 * true = when all the param not set
 * false = when not set
 * */
function check_required_param($param = array(),$method){
    //set up method
    if ($method == "post"){
        $r = $_POST;
    }else if ($method == "get"){
        $r = $_GET;
    }
    //check of required param
    foreach ($param as $par){
        if (!isset($r[$par]) || empty($r[$par])){
            return false;
            break;
        }
    }
    return true;
}

/*
 * Function to check ApiKey
 * this method return
 * true = when api key is valid
 * false = when api key is invalid
 *
 * */
function check_apikey($apikey){
    //check the length of api key
    if (strlen($apikey) != 32){
        return false;
    }
    //check count of apikey in the database
    $count = Db::rowCount("apikeys",array(
        "apikey" => $apikey
    ),array("="));

    return $count == 1 ? true : false;
}