<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

if( !isset( $_GET['id'] ) )
{
  
  header( 'Location: events.php' );
  die();
  
}

if( isset( $_POST['title'] ) )
{
  
  if( $_SERVER["REQUEST_METHOD"] === "POST" )
  // $_POST['title'] and $_POST['id']
  {
    $query = 'UPDATE events SET
      user_id = "'.mysqli_real_escape_string( $connect, $_SESSION['id'] ).'",
      title = "'.mysqli_real_escape_string( $connect, $_POST['title'] ).'",
      type = "'.mysqli_real_escape_string( $connect, $_POST['type'] ).'",
      venue = "'.mysqli_real_escape_string( $connect, $_POST['venue'] ).'",
      price = "'.mysqli_real_escape_string( $connect, $_POST['price'] ).'",
      date = "'.mysqli_real_escape_string( $connect, $_POST['date'] ).'",
      time = "'.mysqli_real_escape_string( $connect, $_POST['time'] ).'",
      description = "'.mysqli_real_escape_string( $connect, $_POST['description'] ).'",
      availability = "'.mysqli_real_escape_string( $connect, $_POST['availability'] ).'",
      video = "'.mysqli_real_escape_string( $connect, $_POST['video'] ).'"
      WHERE id = '.$_GET['id'].'
      LIMIT 1';

    mysqli_query( $connect, $query );
    
    set_message( 'Event has been updated' );
    
  }

  header( 'Location: events.php' );
  die();
  
}


if( isset( $_GET['id'] ) )
{
  
  $query = 'SELECT *
    FROM events
    WHERE id = '.$_GET['id'].'
    LIMIT 1';
  $result = mysqli_query( $connect, $query );
  
  if( !mysqli_num_rows( $result ) )
  {
    
    header( 'Location: events.php' );
    die();
    
  }
  
  $record = mysqli_fetch_assoc( $result );
  
}

?>

<h2>Edit Event</h2>

<form method="post">
  
  <label for="title">Title:</label>
  <input type="text" name="title" id="title" value="<?php echo htmlentities( $record['title'] );?>" required>
  
  <label for="type">Type:</label>
  <?php
  
  $values = array( 'Music', 'Family', 'Comedy', 'Arts', 'Sports' );
  
  echo '<select name="type" id="type">';
  foreach( $values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    if( $value == $record['type'] ) echo ' selected="selected"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  
  ?>
  
  <label for="venue">Venue:</label>
  <input type="text" name="venue" id="venue" value="<?php echo htmlentities( $record['venue'] ); ?>">
  
  <label for="price">Price:</label>
  <input type="number" id="price" name="price" step="0.01" min="1.00" value="<?php echo htmlentities( $record['price'] ); ?>">
    
  <label for="date">Date:</label>
  <input type="date" name="date" id="date" value="<?php echo htmlentities( $record['date'] ); ?>">
  
  <label for="time">Time:</label>
  <input type="time" name="time" id="time" value="<?php echo htmlentities( $record['time'] ); ?>">
  
  <label for="description">Description:</label>
  <textarea type="text" name="description" id="description" rows="10"><?php echo ( $record['description'] ); ?></textarea>

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
      if( $value == $record['availability'] ) echo ' selected="selected"';
      echo '>'.$value.'</option>';
    }
    echo '</select>';
  ?>

  <label for="video">Youtube ID:</label>
  <input type="text" name="video" id="video" value="<?php echo htmlentities( $record['video'] ); ?>">
  
  <input type="submit" value="Edit Event">
  
</form>

<p><a href="events.php"><i class="fas fa-arrow-circle-left"></i> Return to Project List</a></p>


<?php

include( 'includes/footer.php' );

?>