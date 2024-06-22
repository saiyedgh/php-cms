<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );


// will delete the record based on the user's click designed later in the code
if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM artists
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
    
  set_message( 'Artist has been deleted' );
  
  header( 'Location: artists.php' );
  die();
  
}

// main query, selects everything from our artists table and orders it by name A-Z

$query = 'SELECT *
  FROM artists
  ORDER BY name';
$result = mysqli_query( $connect, $query );

echo "<h2>Saved Artists</h2>";

// a while loop to import each record and place it in a card layout
while( $record = mysqli_fetch_assoc( $result ) ):
    // card outer container
    echo '<div class="cards-container flex artists" style="flex-direction:column; align-items:center;">';
        echo '<div>';
            // card inner container
            echo '<div class="card-container flex">';
            $img_exist = array_key_exists('image_url', $record);
            // if the image or the image url exists then display the image, else display a default image
                echo '<div class="artist-img-container">';
                    if($img_exist)
                    {
                        echo '<img src="'.$record['image_url'].'">';
                    } else {

                        $dimensions = 300;
                        echo "<img width='$dimensions' height='$dimensions' src='assets/default.jpeg'>";
                    }
                echo '</div>';
                echo '<div class="flex" style="flex-direction:column; justify-content:space-between;">';
                    echo '<div>';
                        echo '<p>Artist: <b style="color: #904eba">'.$record['name'].'</b></p>';
                        // output the followes with number formatting having commas etc.
                        echo '<p>Followers: '.number_format($record['followers']).'</p>';
                        echo '<a href="'.$record['spotify_url'].'">View artist on Spotify</a>';
                    echo '</div>';
                    echo '<div class="button-container" style="margin: 0 auto; width: 150px;">';
                    // below is the link to delete button which will execute the first delete querry on top?>
                    <a href='artists.php?delete=<?php echo $record['id']; ?>'
                    onclick="javascript:return confirm('Are you sure you want to delete this Artist?');">Remove</i></a>
                    <?php
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
endwhile; ?>

<!-- Takes to search/browse artists page -->
<div class="button-container large" style="margin:1rem auto;">
    <a href="browse_artists.php">Browse Artists</a>
</div>
<!-- Takes to export page where all the saved artists' data is formatted into JSON -->
<div class="button-container large" style="margin:1rem auto;">
    <a href="artists_export.php">Export data to JSON</a>
</div>

<?php

include( 'includes/footer.php' );

?>