<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2018-01-09
 * Time: 8:43 PM
 */


require_once(__DIR__ . '/../database_access.php');

$username = $_REQUEST["username"];

//Check username availability
if(checkUser($username)){
    //User already exists
    echo "false";
}
else{
    //User available
    echo "true";
}