<?php
/**
 * API to update GCM token of an account
 */

require_once "../include/Config.php";

$response = array();

//check for required param
$paramCheck = check_required_param(array("mobile","gcmToken","apikey"),"post");

if (!$paramCheck){
    $response["return"] = false;
    $response["message"] = "Missing required parameters";
    json($response);
}

$gcmToken = e($_POST["gcmToken"]);
$mobile = e($_POST["mobile"]);
$apikey = e($_POST["apikey"]);

//check apikey is valid
if (!check_apikey($apikey)){
    $response["return"] = false;
    $response["message"] = "Invalid apikey";
    json($response);
}

//check mobile number is valid
if (!check_mobile_number_registered(true,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid or Inactive mobile number";
    json($response);
}

//update GcmToken
Db::update("users",array(
    "gcm_token" => $gcmToken
),array("mobile","=",$mobile));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Updated GCM token successfully";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to updated GCM Token";
}
json($response);
