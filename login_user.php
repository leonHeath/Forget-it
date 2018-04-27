<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2017-12-22
 * Time: 5:09 PM
 * @param $password
 * @param $hashedPass
 * @return bool
 */
require_once('database.php');

function checkPass($password, $hashedPass){
    //Check value in hashedPass
    if(password_verify($password, $hashedPass)){
        return true;
    }
    else {
        return false;
    }
}

function login($username, $password){
    $db = new DB();
    $db->query('SELECT password FROM users WHERE user_name = :uname');
    $db->bind(':uname', $username);
    $db->execute();
    $hashedPass = $db->single();
    if(checkPass($password, $hashedPass)){
        //login
        $_SESSION['username'] = $username;
    }
    else{
        print("Unregistered user");
    }
}

session_start();
if (isset($_SESSION['username'])) {
    header("location:Forget-it/index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reg_button'])) {
        //register user action
        print("Hit reg");
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
    } else if (isset($_POST['log_button'])) {
        print("Hit login");
        $username = $_POST['username'];
        $password = $_POST['password'];
        login($username,$password);
    }
}

echo strtr(file_get_contents('login.html'), array());