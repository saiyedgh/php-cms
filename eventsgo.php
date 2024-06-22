
<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' ); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icon.jpg" type="image/icon">
    <title>Events Go</title>
    <link href="styles.css" type="text/css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
  </head>

  <body>
    <div class="main-container">
      <header>
        <div class="nav-container flex">
          <a href="eventsgo.php">
            <div class="logo-container">
              <img src="assets/logo.png" alt="events go logo">
            </div>
          </a>

          <nav class="nav-links flex">
            <div>
              <a href="eventsgo.php">Events Go</a>
            </div>
          </nav>

          <div class="account-container flex">
            <div class="account-img-container">
              <a href="home.php"><img src="assets/account.png" alt="account icon"></a>
            </div>
          </div>

        </div>
      </header>

      <main>         
        <?php echo get_message(); ?>

<?php include( 'includes/wideimage/WideImage.php' );


$query = 'SELECT events.*, users.first, users.last
  FROM events
  LEFT JOIN users ON users.id = events.user_id
  WHERE type = "Music"';
$result = mysqli_query( $connect, $query );

?>

<h2 style="margin: 2rem 0; text-align: center; font-size: calc(2rem+0.5vw);">Our Events</h2>

<h2 class="uppercase front-type-heading" style="text-align: center;"><?php $event_type = mysqli_fetch_assoc($result); echo $event_type['type'] ?></h2>
<?php while( $record = mysqli_fetch_assoc( $result) ): ?>
        <div class="cards-container flex" style="justify-content: center;"> 
            <div class="event-card">
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
                        <h2 class="day"><?php echo $day; ?></h2>
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
                            };?>
                        </p>
                    </div>
                </div>

                <div class="card-box-03">
                    <?php $description = strip_tags($record['description']);?> <!-- Removes the tag information stored in the database by Classic Editor -->
                    <p class="description"><?php echo $description; ?></p>
                    <p class=" posted-by">posted by: <?php echo ( $record['first'] . " " . $record['last'] ); ?></p>
                </div>

                <?php 
                    if ($record['video']) {
                        echo '
                        <h4 class="video-link">Video Link:</h4>
                        <div class="youtube-box">
                            <iframe src="https://www.youtube.com/embed/'. $record["video"] .'?modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>';
                    }
                ?>
                <hr>

            </div>
        </div>
<?php
endwhile; ?>

<?php

$query = 'SELECT events.*, users.first, users.last
  FROM events
  LEFT JOIN users ON users.id = events.user_id
  WHERE type = "Family"';
$result = mysqli_query( $connect, $query );

?>

<h2 class="uppercase front-type-heading" style="text-align: center;"><?php $event_type = mysqli_fetch_assoc($result); echo $event_type['type'] ?></h2>
<?php while( $record = mysqli_fetch_assoc( $result) ): ?>
        <div class="cards-container flex" style="justify-content: center;"> 
            <div class="event-card">
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
                        <h2 class="day"><?php echo $day; ?></h2>
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
                            };?>
                        </p>
                    </div>
                </div>

                <div class="card-box-03">
                    <?php $description = strip_tags($record['description']);?> <!-- Removes the tag information stored in the database by Classic Editor -->
                    <p class="description"><?php echo $description; ?></p>
                    <p class=" posted-by">posted by: <?php echo ( $record['first'] . " " . $record['last'] ); ?></p>
                </div>

                <?php 
                    if ($record['video']) {
                        echo '
                        <h4 class="video-link">Video Link:</h4>
                        <div class="youtube-box">
                            <iframe src="https://www.youtube.com/embed/'. $record["video"] .'?modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>';
                    }
                ?>
                <hr>

            </div>
        </div>
<?php
endwhile; ?>

<?php

$query = 'SELECT events.*, users.first, users.last
  FROM events
  LEFT JOIN users ON users.id = events.user_id
  WHERE type = "Comedy"';
$result = mysqli_query( $connect, $query );

?>

<h2 class="uppercase front-type-heading" style="text-align: center;"><?php $event_type = mysqli_fetch_assoc($result); echo $event_type['type'] ?></h2>
<?php while( $record = mysqli_fetch_assoc( $result) ): ?>
        <div class="cards-container flex" style="justify-content: center;"> 
            <div class="event-card">
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
                        <h2 class="day"><?php echo $day; ?></h2>
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
                            };?>
                        </p>
                    </div>
                </div>

                <div class="card-box-03">
                    <?php $description = strip_tags($record['description']);?> <!-- Removes the tag information stored in the database by Classic Editor -->
                    <p class="description"><?php echo $description; ?></p>
                    <p class=" posted-by">posted by: <?php echo ( $record['first'] . " " . $record['last'] ); ?></p>
                </div>

                <?php 
                    if ($record['video']) {
                        echo '
                        <h4 class="video-link">Video Link:</h4>
                        <div class="youtube-box">
                            <iframe src="https://www.youtube.com/embed/'. $record["video"] .'?modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>';
                    }
                ?>
                <hr>

            </div>
        </div>
<?php
endwhile; ?>

<?php

$query = 'SELECT events.*, users.first, users.last
  FROM events
  LEFT JOIN users ON users.id = events.user_id
  WHERE type = "Arts"';
$result = mysqli_query( $connect, $query );

?>

<h2 class="uppercase front-type-heading" style="text-align: center;"><?php $event_type = mysqli_fetch_assoc($result); echo $event_type['type'] ?></h2>
<?php while( $record = mysqli_fetch_assoc( $result) ): ?>

        <div class="cards-container flex" style="justify-content: center;"> 
            <div class="event-card">
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
                        <h2 class="day"><?php echo $day; ?></h2>
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
                            };?>
                        </p>
                    </div>
                </div>

                <div class="card-box-03">
                    <?php $description = strip_tags($record['description']);?> <!-- Removes the tag information stored in the database by Classic Editor -->
                    <p class="description"><?php echo $description; ?></p>
                    <p class=" posted-by">posted by: <?php echo ( $record['first'] . " " . $record['last'] ); ?></p>
                </div>

                <?php 
                    if ($record['video']) {
                        echo '
                        <h4 class="video-link">Video Link:</h4>
                        <div class="youtube-box">
                            <iframe src="https://www.youtube.com/embed/'. $record["video"] .'?modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>';
                    }
                ?>
                <hr>

            </div>
        </div>
<?php
endwhile; ?>

<?php

$query = 'SELECT events.*, users.first, users.last
  FROM events
  LEFT JOIN users ON users.id = events.user_id
  WHERE type = "Sports"';
$result = mysqli_query( $connect, $query );

?>

<h2 class="uppercase front-type-heading" style="text-align: center;"><?php $event_type = mysqli_fetch_assoc($result); echo $event_type['type'] ?></h2>

<?php while( $record = mysqli_fetch_assoc( $result) ): ?>
        <div class="cards-container flex" style="justify-content: center;"> 
            <div class="event-card">
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
                        <h2 class="day"><?php echo $day; ?></h2>
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
                            };?>
                        </p>
                    </div>
                </div>

                <div class="card-box-03">
                    <?php $description = strip_tags($record['description']);?> <!-- Removes the tag information stored in the database by Classic Editor -->
                    <p class="description"><?php echo $description; ?></p>
                    <p class=" posted-by">posted by: <?php echo ( $record['first'] . " " . $record['last'] ); ?></p>
                </div>

                <?php 
                    if ($record['video']) {
                        echo '
                        <h4 class="video-link">Video Link:</h4>
                        <div class="youtube-box">
                            <iframe src="https://www.youtube.com/embed/'. $record["video"] .'?modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>';
                    }
                ?>
                <hr>

            </div>
        </div>
<?php
endwhile; ?>

<div class="button-container large" style="margin: auto;">
    <a href="home.php"><i class="fas fa-plus-square"></i>Admin Home</a>
</div>

<?php

include( 'includes/footer.php' );
?>