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
}

session_start();
if (isset($_SESSION['username'])) {
    header("location:Forget-it/index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    login($username,$password);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style type = "text/css">
        body{
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
        }
        label{
            display:inline-block;
            width:100px;
            margin-bottom:10px;
            font-size:14px;
        }
        .center {
            text-align: center;
        }
    </style>

</head>
<body>
<div class="center">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <label>Username :</label>
        <input type="text" name="user_name" />
        <br />
        <label>Password :</label>
        <input type="text" name="password" />
        <br />
        <input type="submit" name="submit" value="Submit">
    </form>
    <!--    <div style = "font-size:11px; color:#cc0000; margin-top:10px">--><?php //echo $error; ?><!--</div>-->
</div>


</body>
</html>