<?php

// Load environment variables using vlucas/phpdotenv
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

include('includes/header.php');

// made an app on spotify's developer page which gave us a unique id and secret/key
$my_id = getenv('SPOTIFY_ID');
$my_secret = getenv('SPOTIFY_SECRET');

// this variable has the search record limit, will only search for these numbers of matching records
$limit = 20;

// this code will be executed once the user clicks on the SAVE ARTIST button designed later in the code
if (isset($_GET['id'])) {
    // gets a token to access public data from Spotify
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($my_id . ':' . $my_secret)));

    $result = json_decode(curl_exec($ch), true);
    $token = $result['access_token'];

    // url to get specific data after user's click to save a specific artist
    $url = 'https://api.spotify.com/v1/artists?ids=' . $_GET['id'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // the access token used in the following code
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));

    $result = curl_exec($ch);

    $data = json_decode($result, true);

    $artists = $data["artists"][0];

    $query = 'SELECT * FROM artists WHERE spotify_id="' . $artists['id'] . '"';
    echo $query;
    $result = mysqli_query($connect, $query);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        // insert that specific artist's data into our database
        $query = 'INSERT INTO artists (
                spotify_id,
                name,
                image_url,
                followers,
                spotify_url
            ) VALUES (
                "' . mysqli_real_escape_string($connect, $artists['id']) . '",
                "' . mysqli_real_escape_string($connect, $artists['name']) . '",
                "' . mysqli_real_escape_string($connect, $artists['images']['1']['url']) . '",
                "' . mysqli_real_escape_string($connect, $artists['followers']['total']) . '",
                "' . mysqli_real_escape_string($connect, $artists['external_urls']['spotify']) . '"
            )';
        mysqli_query($connect, $query);
        // if the user clicks on SAVE ARTIST, the following message/notification is displayed
        set_message('Artist has been added');
    } else {
        set_message('Artist already in the list');
    }

    // and the user is directed back to the same search/browse artist page to search for more 
    header('Location: browse_artists.php');
}

?>

<!-- Page's display starts from here -->

<h2>Browse Artists</h2>

<form method="get">
    <!-- Search keywords from this input will be used to match/search that artist's data -->
    <label for="keywords">Keywords:</label>
    <input type="text" name="keywords" id="keywords">
    <br>
    <input class="button-container" style="margin: 0 auto;" type="submit" value="Search">
</form>

<?php

if (isset($_GET['keywords'])) {
    // request to get access/ token from Spotify to public data 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($my_id . ':' . $my_secret)));

    $result = json_decode(curl_exec($ch), true);
    $token = $result['access_token'];

    // if the search keywords have space, replace the space with + as a space won't work in the url
    // the plus sign is what Spotify uses for space in search
    $keywords = str_replace(' ', '+', $_GET['keywords']);

    // url to perform a search based on the entered keywords to a limited number of records
    $url = 'https://api.spotify.com/v1/search?type=artist&include_external=audio&q=' . $keywords .
        '&type=artist&include_external=audio&offset=0&limit=' . $limit;

    // connects the API to the page
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));

    $result = curl_exec($ch);

    $data = json_decode($result, true);

    $artists = $data["artists"]["items"];

    // the search content is displayed in a card style
    echo '<div class="cards-container flex artists" style="flex-direction:column; align-items:center;">';
    echo '<h2>Search Results:</h2>';

    // a loop to place searched/matched records in a card layout
    for ($i = 0; $i < count($artists); $i++) {
        echo '<div>';
        echo '<h3>' . substr($artists[$i]['name'], 0, 30) . '</h3>';
        echo '<div class="card-container flex">';
        // check if the image key exists in the API data
        $img_exist = array_key_exists('1', $artists[$i]['images']);
        echo '<div class="artist-img-container">';
        // if the key exists, display the image from data, else use our default image
        if ($img_exist) {
            echo '<img src="' . $artists[$i]['images']['1']['url'] . '">';
        } else {

            $dimensions = 300;
            echo "<img width='$dimensions' height='$dimensions' src='assets/default.jpeg'>";
        }
        echo '</div>';
        echo '<div class="flex" style="flex-direction:column; justify-content:space-between;">';
        echo '<div>';
        // name is output to a maximum of 30 characters
        echo '<p>Artist: <b style="color: #904eba">' . substr($artists[$i]['name'], 0, 30) . '</b></p>';
        // number is formatted with commas
        echo '<p>Followers: ' . number_format($artists[$i]['followers']['total']) . '</p>';
        echo '<a href="' . $artists[$i]['external_urls']['spotify'] . '">View artist on Spotify</a>';
        echo '</div>';
        // the following code executes the first block of code with a GET id
        echo '<div class="button-container" style="margin: 0 auto; width: 150px;">';
        echo '<a href="browse_artists.php?id=' . $artists[$i]['id'] . '">Save Artist</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    };
    echo '</div>';
}

?>

<!-- Option to take the user to Saved Artists' page -->
<div class="button-container large" style="margin: 0 auto;">
    <a href="artists.php">Go to Saved Artists</a>
</div>

<?php

include('includes/footer.php');

?>
