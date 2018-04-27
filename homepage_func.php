<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2018-04-19
 * Time: 12:56 PM
 */

session_start();
require_once('database_access.php');

if(isset($_REQUEST['func'])){
    $func = $_REQUEST['func'];
    switch ($func){
        case 'delete_task':
            $task_id = $_REQUEST["task_id"];
            deleteTask($task_id);
            break;
        case 'edit_task':
            $task_id = $_REQUEST["task_id"];
            $task_name = $_REQUEST["task_name"];
            $task_desc = $_REQUEST["task_desc"];
            editTask($task_id, $task_name, $task_desc);
            break;
        case 'new_task':
            $username = $_SESSION['username'];
            echo createTask($username);
            break;
        case 'load_tasks':
            $username = $_SESSION['username'];
            echo json_encode(getUserTasks($username));
            break;
        case 'logout_user':
            session_destroy();
            $_SESSION = array();
            echo "Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php";
            break;
        default:
            exit();
    }
}
