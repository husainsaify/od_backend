<?php
require_once "../include/Config.php";

$response = array();

//check for required param
$paramCheck = check_required_param(array("mobile","otp","apikey"),"post");

if (!$paramCheck){
    $response["return"] = false;
    $response["message"] = "Missing required parameters";
    json($response);
}

$otp = e($_POST["otp"]);
$mobile = e($_POST["mobile"]);
$apikey = e($_POST["apikey"]);

//check apikey is valid
if (!check_apikey($apikey)){
    $response["return"] = false;
    $response["message"] = "Invalid apikey";
    json($response);
}

//check otp is valid
$q = Db::query("SELECT id FROM `otp_code` WHERE `mobile`=? AND `otp_code`=?",array($mobile,$otp));
$count = $q->rowCount();

if ($count == 1){
    //make account active
    Db::update("users",array(
        "verified_otp" => "y",
        "active" => "y",
        "last_login" => time()
    ),array("mobile","=",$mobile));

    //success
    $response["return"] = true;
    $response["message"] = "Success";
}else{
    //error
    $response["return"] = false;
    $response["message"] = "Invalid OTP. Try again";
}
json($response);