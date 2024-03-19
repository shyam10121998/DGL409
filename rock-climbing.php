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
            <button onclick="searchNearbyActivities('gym')">Search Nearby Gyming Activities</button>
            <label for="free-toggle">Free Only:</label>
            <input type="checkbox" id="free-toggle" onchange="toggleFree()">
        </div>

        <div class="map-container">
            <div id="map" style="height: 400px; width: 100%;"></div>
            <div id="place-details" class="results-container">
               
            </div>
        </div>
    </div>
</body>
</html>