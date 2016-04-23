<?php
require_once "../include/Config.php";

class SendOTP{

    public static function send($mobile,$otp){

        //Your message to send, Add URL encoding here.
        $message = "your ondew OTP code is {$otp}";

        // init the resource
        $ch = curl_init();

        //Prepare you post parameters
        $param = array(
            'project-app-key' => WHIZAPI_KEY,
            'sms-mobile' => $mobile,
            'sms-text' => $message
        );

        //set options
        curl_setopt($ch,CURLOPT_URL,WHIZAPI_URL."?".http_build_query($param));

        //make sure we get the response when we execute the call
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //exec curl request
        $output = curl_exec($ch);

        //when curl response failed
        if($output == false){
            return false;
        }

        //close curl
        curl_close($ch);

        $json = json_decode($output,true);
        if ($json["ResponseCode"] == 0){
            return true;
        }
        return false;
    }
}