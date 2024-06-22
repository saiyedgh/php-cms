<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM events
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
    
  set_message( 'Event has been deleted' );
  
  header( 'Location: events.php' );
  die();
  
}

$query = 'SELECT events.*, users.first, users.last
  FROM events
  LEFT JOIN users ON users.id = events.user_id
  ORDER BY events.id';
$result = mysqli_query( $connect, $query );

include( 'includes/wideimage/WideImage.php' );

?>

<h2>Manage Events</h2>

<div class="cards-container grid">
  <?php while( $record = mysqli_fetch_assoc( $result ) ): ?>

    <div class="event-card flex">
      <div class="card-box-01 flex">
        <div class="card-img-container">
        <img class="event-img" src="image.php?type=event&id=<?php echo $record['id'];?>&format=outside"> <!-- &width=150&height=150 -->
        </div>
        <div class="schedule-container">
          <?php
            $timestamp = strtotime($record['date']); // Converts the date into time to be resued in another date format
            $day_words = date('D', $timestamp);
            $day = date('j', $timestamp);
            $month = date('M', $timestamp);
            $year = date('y', $timestamp);
          ?>
          <h4 class="day_words"><?php echo $day_words; ?></h4>
          <h2 class="day"><?php if($day < 10){echo '0' . $day;} else{echo $day;}; ?>
          </h2>
          <h4 class="month_year"><?php echo (( $month ) . "-" . ($year) ); ?></h4>
          <p class="time"><?php echo ( $record['time'] ); ?></p>
        </div>
      </div>

      <div class="card-box-02 flex">
        <div class="title_venue">
          <h3 class="title"><?php echo htmlentities( $record['title'] ); ?></h3>
          <p class="venue"><?php echo htmlentities( $record['venue'] ); ?></p>
        </div>
        <div class="price-box">
          <p class="price">$<?php echo htmlentities( $record['price'] ); ?></p>
          <p class="availability"><?php
            if( $record['availability'] ==  'yes')
            {
              echo ' Available';
            } else {
              echo ' Sold out';
            }?>
          </p>
        </div>
      </div>

      <div class="card-box-03">
        <?php $description = strip_tags($record['description']);?> <!-- Removes the tag information stored in the database by Classic Editor -->
        <p class="description"><?php echo ($description); ?></p> 
        <p class=" posted-by">posted by: <?php echo ( $record['first'] . " " . $record['last'] ); ?></p>
      </div>

      <div class="card-box-04 flex">
        <div class="photo-box button-container">
          <a href="events_photo.php?id=<?php echo $record['id']; ?>">Photo</i></a>
        </div>
        <div class="delete-box button-container">
          <a href="events.php?delete=<?php echo $record['id']; ?>" onclick="javascript:return confirm('Are you sure you want to delete this Event?');">Delete</i></a>
        </div>
        <div class="edit-box button-container">
          <a href="events_edit.php?id=<?php echo $record['id']; ?>">Edit</i></a>
        </div>
      </div>
      
    </div>
    
  <?php endwhile; ?>
</div>

<div class="button-container add-event large">
    <a href="events_add.php"><i class="fas fa-plus-square"></i> Add Event</a>
</div>


<?php

include( 'includes/footer.php' );

?>