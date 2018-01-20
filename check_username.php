<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2018-01-09
 * Time: 8:43 PM
 */


require_once('database.php');

$username = $_REQUEST["username"];
$db = new DB();
$db->query("SELECT user_name FROM users WHERE user_name = :uname");
$db->bind(':uname', $username);
$db->execute();
$user = $db->single();
if($user){
    echo "false";
}
else{
    echo "true";
}