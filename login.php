<?php

// print_r($_POST);
// die;

require_once './db_connection.php';

try {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $alreadyExist = "SELECT * FROM `user` WHERE `email` = '" . $email . "'" . " and `password` = '" . md5($password) . "'";

    $result = $conn->query($alreadyExist);

    if ($result->num_rows > 0) {

        session_start();

        while ($row = $result->fetch_assoc()) {
            // echo $row['flag'];
            // die;
            if (isset($row['id'])) {

                $_SESSION["fullName"] = $row['full_name'];

                break;
            } else {
                die('Email or Password is Incorrect');
            }
        }
    }

    header('Location: stories.php');
} catch (\Exception $e) {
    die($e->getMessage());
}