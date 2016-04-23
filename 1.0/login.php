<?php
require_once "../include/Config.php";

$response = array();

//check for required param
$paramCheck = check_required_param(array("mobile","apikey"),"post");

if (!$paramCheck){
    $response["return"] = false;
    $response["message"] = "Missing required parameters";
    json($response);
}

$mobile = e($_POST["mobile"]);
$apikey = e($_POST["apikey"]);

//check apikey is valid
if (!check_apikey($apikey)){
    $response["return"] = false;
    $response["message"] = "Invalid apikey";
    json($response);
}

//login the user
$query = Db::query("SELECT `mobile` FROM `users` WHERE mobile=?",array($mobile));

//check count that this mobile is avaiable or not
if ($query->rowCount() != 1){
    $response["return"] = false;
    $response["message"] = "{$mobile} is not registered. Enter valid registered mobile number provided by your school";
    json($response);
}

//generate a random otp code
$otpCode = generate_otp();

//delete old OTP
Db::delete("otp_code",array("mobile","=",$mobile));

//add new OTP code
Db::insert("otp_code",array(
    "mobile" => $mobile,
    "otp_code" => $otpCode
));

$result = SendOTP::send($mobile,$otpCode);

if ($result){
    //success
    $response["return"] = true;
    $response["message"] = "OTP send successfully";
}else{
    //error
    $response["return"] = false;
    $response["message"] = "Unable to send OTP. Please try again";
}

json($response);
