<?php
/**
 * Created by PhpStorm.
 * User: Leon
 * Date: 2018-03-05
 * Time: 9:55 PM
 */

require_once('database.php');

function checkUser($username){
    $db = new DB();
    $db->query("SELECT user_name FROM users WHERE user_name = :uname");
    $db->bind(':uname', $username);
    $db->execute();
    $user = $db->single();
    if($user){
        return true;
    }
    else{
        return false;
    }
}

function getUserTasks($username){
    $db = new DB();
    $db->query('SELECT task_id, task_name, task_proj, task_desc FROM tasks WHERE task_creator = :tcreator');
    $db->bind(':tcreator', $username);
    $db->execute();
    $tasks = $db->result_set();
    return $tasks;
}

function createTask($username){
    $db = new DB();
    $task_name = "Default task";
    $task_desc = "Write task description here.";
    $db->query('INSERT INTO tasks(task_name, task_desc, task_creator) VALUES (:tname, :tdesc, :tcreator)');
    $db->bind(':tname', $task_name);
    $db->bind(':tcreator', $username);
    $db->bind(':tdesc', $task_desc);
    $db->execute();
    return $db->getLastId("task_id");
}

function createProject($proj_name){
    $db = new DB();
    $db->query('INSERT INTO projects(proj_name) VALUES (:pname)');
    $db->bind(':pname', $proj_name);
    $db->execute();
}

function editTask($task_id, $task_name, $task_desc){
    $db = new DB();
    $db->query('UPDATE tasks SET task_name = :tname, task_desc = :tdesc WHERE task_id = :tid');
    $db->bind(':tname', $task_name);
    $db->bind(':tdesc', $task_desc);
    $db->bind(':tid', $task_id);
    $db->execute();
}

function deleteTask($task_id){
    $db = new DB();
    $db->query('DELETE FROM tasks WHERE task_id = :tid');
    $db->bind(':tid', $task_id);
    $db->execute();
}