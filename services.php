<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>FitFinder</title>
<style>

  #map {
    height: 400px;
    width: 100%;
  }

  #place-details {
    margin-top: 20px;
  }

  .place-detail {
    border: 1px solid #ccc;
    margin-bottom: 10px;
    padding: 10px;
  }
</style>
</head>
<body>

<?php include 'header.php'; ?>



    <div class="slider-container">
          <div class="slide">
              <img src="images/woman-1867074_1920.jpg" alt="Image 1">
              <div class="slide-content">
                  <h1>FitFinder: Your journey to fitness starts here!</h1>
                  <a href="#fitfinder-section" class="slider-button">Discover</a>
              </div>
          </div>
    </div>

<!--info section-->

<section id="fitfinder-section">
    <div class="info">
        <h2>Welcome to FitFinder</h2>
        <p>Discover a world of fitness activities tailored to your interests and preferences. Whether you're into hiking, yoga, or swimming, FitFinder has something for everyone. Start your fitness journey today!</p>
        <a href="#activities-section" class="btn">Explore Activities</a>
    </div>
</section>

  
 <!-- Energy Level Content -->
 <div class="energy-level" id="activities-section">
 <div class="energy-level-content">
    <h2>Find Your Fit</h2>
    <p>Discover activities tailored to your energy level.</p>
    <div class="level-options">
      <a href="high.html" class="level high">High energy</a>
      <a href="moderate.html" class="level moderate">Moderate energy</a>
      <a href="low.html" class="level low">Low energy</a>
    </div>
    <div class="separator"></div>
    <h3>Or Search Any Activity:</h3>
    <div class="search-container">
      <input type="text" id="place" placeholder="Enter a place or activity">
      <input type="text" id="distance" placeholder="Distance (in meters)">
      <button onclick="searchNearbyPlaces()">Search Nearby Places</button>
  </div>

  </div>
 </div>

  <div class="map-container">
    <div id="map" style="height: 400px; width: 50%;"></div>
    <div id="place-details" class="activity-container"></div>
</div>



  <script>
    let map;
    let service;
    let infowindow;
    let markers = [];
  
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
      document.getElementById("location").innerHTML = `Your current location: ${position.coords.latitude}, ${position.coords.longitude}`;
      searchNearbyPlaces();
    }
  
    function searchNearbyPlaces() {
      const query = document.getElementById("place").value;
      const radius = document.getElementById("distance").value;
  
      if (!query.trim()) {
        alert("Please enter a valid search query.");
        return;
      }
  
      if (!radius || isNaN(radius) || radius <= 0) {
        alert("Please enter a valid distance (in meters).");
        return;
      }
  
      const request = {
        location: map.getCenter(),
        radius: radius,
        query: query,
      };
  
      service = new google.maps.places.PlacesService(map);
      service.textSearch(request, callback);
    }
  
    function callback(results, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {
        clearMarkers();
        for (let i = 0; i < results.length; i++) {
          createMarker(results[i]);
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
    <div class="place-details-container">
    <div class="place-details-text">
        <p><strong>Name:</strong> ${place.name}</p>
        <p><strong>Address:</strong> ${place.formatted_address}</p>
        <p><strong>Rating:</strong> ${place.rating ? place.rating : 'N/A'}</p>
        <p><strong>Open Now:</strong> ${openingHours}</p>
        <p><strong>Opening Hours:</strong><br> ${openingHours}</p>
        </div>
    <div class="place-details-image">
        <img src="${photoUrl}" alt="Place Photo">
    </div>
</div>
    `;
}

  
    function clearMarkers() {
      for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
      }
      markers = [];
    }

  
  </script>
  
  
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtOEtcnrjVWnTea8XNCQ52KUOAb0_US8o&callback=initMap&libraries=places"></script>

<?php include 'footer.php'; ?>
  


</body>

</html>
