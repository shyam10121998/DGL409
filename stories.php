<?php

session_start();

require_once './db_connection.php';

if (!$_SESSION['fullName']) {
    header('Location:index.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process the story submission (You can implement this in submit_story.php)
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
<?php include 'header.php'; ?>


    <?php

    $selectSql = "SELECT * from `stories` ";



    $result = $conn->query($selectSql);

    if ($result->num_rows > 0) {

      echo "<div class='intro-text'>
      <h2>Share your experiences below and let others know about your adventures!</h2>
  </div>";

        while ($row = $result->fetch_assoc()) {


            echo "<div class='story-container'>
          
          <div class='story-content'>
            <img src=" . "images/" . $row['image'] . " alt='' style='width:150px;height:100px;'/>
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

    <?php include 'footer.php'; ?>
</body>
</html>