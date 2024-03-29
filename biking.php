<?php

require_once './db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Biking Activities</title>
</head>
<body>
<?php include 'header.php'; ?>

</header>
 <img src="images/biking.webp" alt="biking page banner" style="height: 800px; width: 100%;">
    <div class="energy-level">
  <h2>Biking Activities</h2>
  <p>Enter your desired distance from current location:</p>
  <div class="search-container">
    <button onclick="searchNearbyActivities('bike')">Search Nearby Biking Activities</button>
    <label for="free-toggle">Free Only:</label>
    <input type="checkbox" id="free-toggle" onchange="toggleFree()">
  </div>
</div>
<div class="map-container">
  <div id="map" style="height: 400px; width: 50%;"></div>
  <div id="place-details" class="results-container"></div>
  <div id="content">
  <?php

$sql = "SELECT * FROM `free_activities` WHERE `activity` = 'biking'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while ($row = $result->fetch_assoc()) {
      echo '<div class="activity-container">';
      echo '<p><strong>Name:</strong>' . $row['name'] . '</p>';
      echo '<p><strong>Address:</strong> <a href="' . $row['map_link'] . '">' . $row['address'] . '</a></p>';
      echo '<p><strong>Rating:</strong> ' . $row['rating'] . '</p>';
      echo '<p><strong>Open Now:</strong> ' . $row['open_now'] . '</p>';
      echo '<p><strong>Rates:</strong> ' . $row['rates'] . '</p>';
      echo '<p><strong>Opening Hours:</strong><br> ' . $row['working_hours'] . '</p>';
      echo '<img src="images/' . $row['image'] . '" alt="Place Photo" style="max-width: 500px; height: 400px;">';
      echo '</div>';// reference AI
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
      center: { lat: -34.397, lng: 150.644 },
      zoom: 15,
    });
    infowindow = new google.maps.InfoWindow();
    getLocation();
  }

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }

  function showPosition(position) {
    const latLng = new google.maps.LatLng(
      position.coords.latitude,
      position.coords.longitude
    );
    map.setCenter(latLng);
    const marker = new google.maps.Marker({
      position: latLng,
      map: map,
    });
    infowindow.setContent("You are here!");
    infowindow.open(map, marker);
  }

  function searchNearbyActivities(activityType) {
      const request = {
        location: map.getCenter(),
        radius: 1000, // Set a default radius (in meters)
        query: activityType,
      };

      service = new google.maps.places.PlacesService(map);
      service.textSearch(request, callback);
    }

  function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
      clearMarkers();
      for (let i = 0; i < results.length; i++) {
        if (!freeOnly || (results[i].price_level === 0 && results[i].rating >= 3)) {
          createMarker(results[i]);
        }
      }
    }
  }

  function createMarker(place) {
    const marker = new google.maps.Marker({
      map,
      position: place.geometry.location,
    });

    markers.push(marker);

    google.maps.event.addListener(marker, "click", () => {
      infowindow.setContent(place.name);
      infowindow.open(map, marker);
      showPlaceDetails(place);
    });
  }

  function showPlaceDetails(place) {
    const detailsContainer = document.getElementById("place-details");
    const photoUrl = place.photos && place.photos.length > 0 ? place.photos[0].getUrl() : '';
    let openingHours = place.opening_hours ? (place.opening_hours.open_now ? 'Yes' : 'No') : 'N/A';

    if (place.opening_hours && place.opening_hours.weekday_text) {
      openingHours = '';
      place.opening_hours.weekday_text.forEach(time => {
        openingHours += `${time}<br>`;
      });
    }

    detailsContainer.innerHTML = `
    <div class="activity-container">
      <p><strong>Name:</strong> ${place.name}</p>
      <p><strong>Address:</strong> ${place.formatted_address}</p>
      <p><strong>Rating:</strong> ${place.rating ? place.rating : 'N/A'}</p>
      <p><strong>Open Now:</strong> ${openingHours}</p>
      <p><strong>Rates:</strong> ${place.rates ? place.rates : 'N/A'}</p>
      <p><strong>Opening Hours:</strong><br> ${openingHours}</p>
      <img src="${photoUrl}" alt="Place Photo" style="max-width: 500px; height: 400px;">
      </div>`;
  }

  function clearMarkers() {
    for (let i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }
    markers = [];
  }

  function toggleFree() {
    freeOnly = !freeOnly;
    const contentDiv = document.getElementById("content");
        contentDiv.hidden = !event.target.checked;
        if (event.target.checked) {
            $("#content").show();
        } else {
            $("#content").hide();
        }
  }
</script>

<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtOEtcnrjVWnTea8XNCQ52KUOAb0_US8o&callback=initMap&libraries=places"></script>

</body>
</html>
