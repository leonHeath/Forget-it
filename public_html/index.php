<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2017-11-20
 * Time: 11:03 PM
 * Access db on http://localhost/phpmyadmin/
 * @param $password
 * @param $hashedPass
 * @return bool
 */

session_start();
require_once('database.php');

function checkPass($password, $hashedPass){
    //Check value in hashedPass
    if($hashedPass && password_verify($password, $hashedPass)){
        return true;
    }
    else {
        return false;
    }
}

function encryptPass($password){
    return password_hash($password, PASSWORD_DEFAULT);
}

function login($username, $password){
    $db = new DB();
    $db->query('SELECT password, first_name, last_name FROM users WHERE user_name = :uname');
    $db->bind(':uname', $username);
    $db->execute();
    $user = $db->single();
    if($user && checkPass($password, $user['password'])){
        //login
        $_SESSION['username'] = $username;
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        header("location:homepage.php");
        exit();
    }
    else{
        //TODO
        print("Unregistered user");
    }
}

function register($first_name, $last_name, $username, $password){
    $db = new DB();
    $pass_encrypt = encryptPass($password);
    $db->query('INSERT INTO users(first_name, last_name, user_name, password)
    VALUES(:fname, :lname, :uname, :pass)');
    $db->bind(':fname', $first_name);
    $db->bind(':lname', $last_name);
    $db->bind(':uname', $username);
    $db->bind(':pass', $pass_encrypt);
    $db->execute();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reg_button'])) {
        //register user action
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $password = $_POST['password_1'];
        register($first_name,$last_name,$username,$password);
    } else if (isset($_POST['log_button'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        login($username,$password);
    }
}

if (isset($_SESSION['username'])) {
    header("location:homepage.php");
}
else{
    require_once 'login.html';
}

