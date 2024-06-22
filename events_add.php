<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

if( isset( $_POST['title'] ) )
{  
  if( $_SERVER["REQUEST_METHOD"] === "POST" )
  {
    $query = 'INSERT INTO events (
        user_id,
        title,
        type,
        venue,
        price,
        date,
        time,
        description,
        availability,
        video
      ) VALUES (
        "'.mysqli_real_escape_string( $connect, $_SESSION['id'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['title'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['type'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['venue'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['price'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['date'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['time'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['description'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['availability'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['video'] ).'"
      )';

    mysqli_query( $connect, $query );
    
    set_message( 'Event has been added' );
    
  }
  
  header( 'Location: events.php' );
  die();
  
}

?>

<h2>Add Project</h2>

<form method="post">
  
  <label for="title">Title:</label>
  <input type="text" name="title" id="title" required>
  
  <label for="type">Type:</label>
  <?php
  
  $values = array( 'Music', 'Family', 'Comedy', 'Arts', 'Sports' );
  
  echo '<select name="type" id="type">';
  foreach( $values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  
  ?>
  
  <label for="venue">Venue:</label>
  <input type="text" name="venue" id="venue">
  
  <label for="price">Price:</label>
  <input type="number" id="price" name="price" step="0.01" min="1.00">
    
  <label for="date">Date:</label>
  <input type="date" name="date" id="date">
  
  <label for="time">Time:</label>
  <input type="time" name="time" id="time">
  
  <label for="description">Description:</label>
  <textarea type="text" name="description" id="description" rows="10"></textarea>

  <script>

  ClassicEditor
    .create( document.querySelector( '#description' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
    
  </script>
  
  <label for="availability">Available:</label>
  <?php
  
  $values = array( 'yes', 'no' );
  
  echo '<select name="availability" id="availability">';
  foreach( $values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  
  ?>

  <label for="video">Youtube ID:</label>
  <input type="text" name="video" id="video">
  
  <input type="submit" value="Add Event">
  
</form>

<p><a href="events.php"><i class="fas fa-arrow-circle-left"></i> Return to Events List</a></p>


<?php

include( 'includes/footer.php' );

?>