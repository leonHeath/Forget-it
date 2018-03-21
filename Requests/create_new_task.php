<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2018-03-07
 * Time: 11:28 PM
 */

session_start();

require_once(__DIR__ . '/../database_access.php');

$username = $_SESSION['username'];

echo createTask($username);

