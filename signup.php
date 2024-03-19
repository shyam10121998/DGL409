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
    $confirmPassword = $_POST['confirm-password'];}