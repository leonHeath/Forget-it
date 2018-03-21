<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2018-03-17
 * Time: 8:17 AM
 */

session_start();

require_once(__DIR__ . '/../database_access.php');

$task_id = $_POST["task_id"];
$task_name = $_POST["task_name"];
$task_desc = $_POST["task_desc"];

editTask($task_id, $task_name, $task_desc);