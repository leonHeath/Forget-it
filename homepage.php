<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
else{
    require_once 'homepage.html';
}

