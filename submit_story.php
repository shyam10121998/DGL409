<?php

require_once './db_connection.php';

try {

    $target_dir = "uploads/";

    $noOfFiles = count($_FILES['photos']['name']);

    for ($i = 0; $i < $noOfFiles; $i++) {

        $target_file = $target_dir . basename($_FILES["photos"]["name"][$i]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["photos"]["size"][$i] > 500000) {
            die("Sorry, your file is too large.");
            $uploadOk = 0;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "webp"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            die("Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["photos"]["tmp_name"][$i], $target_file)) {
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    $placeName = $_POST['place_name'];
    $date_of_travel = $_POST['date_of_travel'];
    $rating = $_POST['rating'];
    $likes = $_POST['likes'];
    $notes = $_POST['notes'];

    if ($placeName && $date_of_travel && $rating  && $likes && $notes) {

        $firstPhoto = $_FILES["photos"]["name"][0];

        $storyInsertSql = "INSERT INTO `stories` 
            (`place_name`,`date_of_travel`,`rating`,`likes`,`notes`,`image`) VALUES
            ('$placeName','$date_of_travel','$rating','$likes','$notes','$firstPhoto')";

        $result = $conn->query($storyInsertSql);

        header('Location: stories.php');
    } else {
        die('All Fields Are required');
    }
} catch (Exception $e) {
    die($e->getMessage());
}
