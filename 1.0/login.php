<?php
require_once "../include/Config.php";

$response = array();

$data = check_required_param(array("hello","hello1"),"post");

var_dump($data);