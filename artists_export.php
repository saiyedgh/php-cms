<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );


// pulls in data from the database
$query = 'SELECT *
  FROM artists
  ORDER BY followers DESC';
$result = mysqli_query( $connect, $query );

$data = array();

while( $record = mysqli_fetch_assoc( $result ) ):

// puts the uploaded data into an array
    $data[] = $record;   

endwhile;

// encodes the array to JSON format and the PRETTIER function with the PRE tag formats into a more readable product
echo "<pre>";
echo json_encode($data, JSON_PRETTY_PRINT);
echo "</pre>";

?>
