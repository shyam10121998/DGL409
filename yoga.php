<?php

require_once './db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gyming Activities</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

    <div class="energy-level">
        <h2>Gyming Activities</h2>
        <p>Enter your desired distance from current location:</p>
        <div class="search-container">
            <input type="text" id="distance" placeholder="Distance (in meters)">
            <button onclick="searchNearbyActivities('gym')">Search Nearby Gyming Activities</button>
            <label for="free-toggle">Free Only:</label>
            <input type="checkbox" id="free-toggle" onchange="toggleFree()">
        </div>
    </div>

        <div class="map-container">
            <div id="map" style="height: 400px; width: 100%;"></div>
            <div id="place-details" class="results-container">
            <div id="content">

            <?php

                $sql = "SELECT * FROM `free_activities` WHERE `activity` = 'yoga' ";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        echo '<p><strong>Name:</strong>' . $row['name'] . '</p>
                          <p><strong>Address:</strong> <a href=' . $row['map_link'] . '>' . $row['address'] . '</a></p>
                          <p><strong>Rating:</strong> ' . $row['rating'] . '</p>
                          <p><strong>Open Now:</strong> ' . $row['open_now'] . '</p>
                          <p><strong>Opening Hours:</strong><br> ' . $row['working_hours'] . '</p>
                          <img src="images/' . $row['image'] . '" alt="Place Photo" style="max-width: 500px; height: 400px;">';
                    }
                }

                ?>

        </div>
    </div>

    <script>
        let map;
        let service;
        let infowindow;
        let markers = [];
        let freeOnly = false;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: -34.397,
                    lng: 150.644
                },
                zoom: 15,
            });
            infowindow = new google.maps.InfoWindow();
            getLocation();
        }

    </script>
</body>
</html>
