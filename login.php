<?php

// print_r($_POST);
// die;

require_once './db_connection.php';

try {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $alreadyExist = "SELECT * FROM `user` WHERE `email` = '" . $email . "'" . " and `password` = '" . md5($password) . "'";

    $result = $conn->query($alreadyExist);
}