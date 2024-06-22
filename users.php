<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM users
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
  
  set_message( 'User has been deleted' );
  
  header( 'Location: users.php' );
  die();
  
}

$query = 'SELECT *
  FROM users
  ORDER BY last,first';
  
  //.( ( $_SESSION['id'] != 1 and $_SESSION['id'] != 4 ) ? 'WHERE id = '.$_SESSION['id'].' ' : '' ).'
$result = mysqli_query( $connect, $query );

?>

<h2 class="manage-users">Manage Users</h2>

<div class="users-table-container">
  <table class="users-table">

    <tr class="bottom-border">
      <th align="center">Name</th>
      <th align="center">Email</th>
      <th align="center">Active</th>
    </tr>
    <?php while( $record = mysqli_fetch_assoc( $result ) ): ?>
      <tr class="table-row-padding">
        <td align="left"><?php echo htmlentities( $record['first'] ); ?> <?php echo htmlentities( $record['last'] ); ?></td>
        <td align="left"><?php echo ( $record['email'] ); ?></td>
        <td align="center">
          <?php echo $record['active']; ?>
        </td>
      </tr>
      <tr class="bottom-border">
        <td></td>
        <td align="right">
          <?php if( $_SESSION['id'] != $record['id'] ): ?>
            <a href="users.php?delete=<?php echo $record['id']; ?>" onclick="javascript:return confirm('Are you sure you want to delete this user?');">Delete</a>
          <?php endif; ?>
        </td>
        <td align="right"><a href="users_edit.php?id=<?php echo $record['id']; ?>">Edit</a></td>
      </tr>
    <?php endwhile; ?>

  </table>

  <div class="button-container large">
    <a href="users_add.php"><i class="fas fa-plus-square"></i> Add User</a>
  </div>

</div>




<?php

include( 'includes/footer.php' );

?>