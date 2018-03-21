<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2018-03-17
 * Time: 8:22 AM
 */

session_start();

require_once(__DIR__ . '/../database_access.php');

$task_id = $_POST["task_id"];

echo json_encode(deleteTask($task_id));