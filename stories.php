<?php

session_start();

require_once './db_connection.php';

if (!$_SESSION['fullName']) {
    header('Location:services.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="header">
        <img src="#" alt="FitFinder Logo" class="logo">
        <div class="nav-stories">
          <a href="contact.html">Contact Us</a>
          <a href="stories.html">Stories</a>
          <a href="services.html">Services</a>
        </div>
    </div>

    
    <!-- Story 1 -->
    <div class="story-container">
        <h2>Exploring the Mountains of Nepal</h2>
        <div class="story-content">
            <img src="mountains.jpg" alt="Mountains in Nepal">
            <p><strong>Place Name:</strong> Himalayas</p>
            <p><strong>Date of Travel:</strong> February 2023</p>
            <p><strong>Photos:</strong> <a href="#">View Photos</a></p>
            <p><strong>Rating:</strong> 5</p>
            <p><strong>What I Liked:</strong> The breathtaking views and serene atmosphere.</p>
            <p><strong>Additional Notes:</strong> A life-changing experience that I'll never forget.</p>
        </div>
    </div>

    <!-- Story 2 -->
    <div class="story-container alternate">
        <h2>Island Hopping in Thailand</h2>
        <div class="story-content">
            <img src="beach.jpg" alt="Beach in Thailand">
            <p><strong>Place Name:</strong> Koh Phi Phi</p>
            <p><strong>Date of Travel:</strong> July 2022</p>
            <p><strong>Photos:</strong> <a href="#">View Photos</a></p>
            <p><strong>Rating:</strong> 4</p>
            <p><strong>What I Liked:</strong> Crystal-clear waters and vibrant marine life.</p>
            <p><strong>Additional Notes:</strong> A paradise on earth, perfect for relaxation.</p>
        </div>
    </div>

    <!-- Story 3 -->
    <div class="story-container">
        <h2>Adventures in the Amazon Rainforest</h2>
        <div class="story-content">
            <img src="amazon.jpg" alt="Amazon Rainforest">
            <p><strong>Place Name:</strong> Amazon Rainforest</p>
            <p><strong>Date of Travel:</strong> May 2021</p>
            <p><strong>Photos:</strong> <a href="#">View Photos</a></p>
            <p><strong>Rating:</strong> 5</p>
            <p><strong>What I Liked:</strong> Immersion in nature and encounters with wildlife.</p>
            <p><strong>Additional Notes:</strong> An unforgettable adventure filled with wonder and discovery.</p>
        </div>
    </div>

    <?php

    $selectSql = "SELECT * from `stories` ";



    $result = $conn->query($selectSql);

    if ($result->num_rows > 0) {


        while ($row = $result->fetch_assoc()) {


            echo "<div class='story-container'>
          
          <div class='story-content'>
            <img src=" . "uploads/" . $row['image'] . " alt='Amazon Rainforest' style='width:150px;height:100px;'/>
            <p><strong>Place Name:</strong>" . $row['place_name'] . "</p>
            <p><strong>Date of Travel:</strong> " . $row['date_of_travel'] . "</p>
            <p><strong>Rating:</strong> " . $row['rating'] . "</p>
            <p>
              <strong>What I Liked:</strong> " . $row['likes'] . "
      
            </p>
            <p>
              <strong>Additional Notes:</strong> " . $row['rating'] . "
            </p>
          </div>
        </div>";
        }
    }

    //   

    ?>

    <!--story form-->
    <div class="story-form-container">
        <h2>Share Your Experience</h2>
        <form action="submit_story.php" method="POST" enctype="multipart/form-data">
            <label for="place_name">Place Name:</label>
            <input type="text" id="place_name" name="place_name" required>

            <label for="date_of_travel">Date of Travel:</label>
            <input type="date" id="date_of_travel" name="date_of_travel" required>

            <label for="photos">Upload Photos:</label>
            <input type="file" id="photos" name="photos[]" accept="image/*" multiple>

            <label for="rating">Rate the Place:</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>

            <label for="likes">What did you like about this place?</label>
            <textarea id="likes" name="likes" rows="4" required></textarea>

            <label for="notes">Additional Notes:</label>
            <textarea id="notes" name="notes" rows="4"></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>