<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

// secure();

include( 'includes/header.php' );

// $url = "https://api.spotify.com/v1/artists";
// $key = "e1e6ac4b1e764eb4a19f0af385d9b445";

$my_id = "27626cd624644b2a8bcbe8c13b43f1f3";
$my_secret = "e1e6ac4b1e764eb4a19f0af385d9b445";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token' );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials' ); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($my_id.':'.$my_secret))); 

$result = json_decode(curl_exec($ch), true);
$token = $result['access_token'];

// echo '<pre>';
// print_r($result);
// echo '</pre>';

// echo '<hr>';

$url = 'https://api.spotify.com/v1/search?type=artist&include_external=audio&q=smashing';
// $url = 'https://api.spotify.com/v1/artists?ids=2CIMQHirSU0MQqyYHq0eOx,40Yq4vzPs9VNUrIBG5Jr2i';
// $url = 'https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));

$result=curl_exec($ch);

echo '<pre>';
print_r($result);
echo '</pre>';


// $ch = curl_init();
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_URL, $url);


// // curl_setopt($ch, CURLOPT_POST, 1);
// // curl_setopt($ch, CURLOPT_POSTFIELDS, POST DATA);
// $result = curl_exec($ch);
// print_r($result);
// curl_close($ch);

// $data = json_decode($result, true);
// print_r($data);





?>


<?php

include( 'includes/footer.php' );

?>