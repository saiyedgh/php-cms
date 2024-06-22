<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

?>

<ul id="dashboard" class="flex">
  <li class="button-container large">
    <a href="events.php">
      Manage Events
    </a>
  </li>
  <li class="button-container large">
    <a href="users.php">
      Manage Users
    </a>
  </li>
  <li class="button-container large">
    <a href="browse_artists.php">
      Browse Artists
    </a>
  </li>
  <li class="button-container large">
    <a href="artists.php">
      Saved Artists
    </a>
  </li>
  <li>
    <a href="logout.php">Logout</a>
  </li>
</ul>

<?php

include( 'includes/footer.php' );

?>
