<?php

// print_r($_POST);
// die;

require_once './db_connection.php';

try {
    $fullName = $_POST['fullname'];
    $username = $_POST['username'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if ($password != $confirmPassword) {
        die('Password and Confirm Password should be mathched');
    }

    $alreadyExist = "SELECT count(*) as flag FROM `user` WHERE `email` = '" . $email . "'";


    $result = $conn->query($alreadyExist);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            if ($row['flag']) {

                $conn->close();
                die('Email Already Exist !');
            }
        }
    }

    if ($fullName && $username && $dob && $email && $password && $confirmPassword) {

        $hashedPassword = md5($password);

        $signUpSql = "INSERT INTO `user` 
            (`full_name`,`dob`,`email`,`password`) VALUES
            ('$fullName','$dob','$email','$hashedPassword')";

        $result = $conn->query($signUpSql);

        header('Location: login.html');
    } else {
        die('All Fields Are required');
    }
} catch (\Exception $e) {
    die($e->getMessage());}