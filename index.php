<?php

// Load environment variables using vlucas/phpdotenv
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

if (isset($_POST['email'])) {
    $query = 'SELECT *
    FROM users
    WHERE email = "' . $_POST['email'] . '"
    AND password = "' . md5($_POST['password']) . '"
    AND active = "Yes"
    LIMIT 1';

    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result)) {
        $record = mysqli_fetch_assoc($result);

        $_SESSION['id'] = $record['id'];
        $_SESSION['email'] = $record['email'];

        header('Location: home.php');
        die();
    } else {
        set_message('Incorrect email and/or password');

        header('Location: index.php');
        die();
    }
}

include('includes/header.php');
?>

<div style="max-width: 400px; margin:auto">
    <div class="events-go-branding">
        <div class="main-logo-container">
            <img src="assets/logo_black.png" alt="events go logo" width="100px">
        </div>
        <h3>Events Go</h3>
    </div>
    <form method="post">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="Login">
    </form>
    <div style="text-align:center;">
        <a href="eventsgo.php">Continue as Guest</a>
    </div>
</div>

<?php
include('includes/footer.php');
?>
