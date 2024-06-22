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
              <a href="home.php">Home</a>
            </div>
            <div>
              <a href="events.php">Events</a>
            </div>
            <div>
              <a href="users.php">Users</a>
            </div>
            <div>
              <a href="artists.php">Artists</a>
            </div>
          </nav>

          <div class="account-container flex">
            <div class="account-img-container">
              <a href="home.php"><img src="assets/account.png" alt="account icon"></a>
            </div>

            <?php if (isset($_SESSION['id'])) {
              echo'<div class="logout-box">
                <a href="logout.php">Logout</a>
              </div>';
            }
          ?>
          </div>

        </div>
      </header>

      <main>         
        <?php echo get_message(); ?>
    
    
  
