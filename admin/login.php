<?php
session_start();
include('../config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize user input
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

  // Use prepared statements to prevent SQL injection
  $sql = "SELECT * FROM tbl_admin WHERE username = ? LIMIT 1";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $username);

  // Check if the query executed successfully
  if (!mysqli_stmt_execute($stmt)) {
    // Display an error message
    $_SESSION['login_error'] = 'Something went wrong while logging in. Please try again later.';
    header('location:' . SITEURL . 'admin/login.php');
  } else {
    // Get the result of the query
    $result = mysqli_stmt_get_result($stmt);

    // Check if the user exists and the password matches
    if ($result && mysqli_num_rows($result) == 1 && password_verify($password, mysqli_fetch_assoc($result)['password'])) {
      // Set the session variables and redirect to the admin index page
      $_SESSION['login'] = true;
      $_SESSION['user'] = $username;
      header('Location:' . SITEURL . 'admin/index.php', true, 302);
    } else {
      // If the user is not found or the password does not match, display an error message
      $_SESSION['login_error'] = 'Invalid username or password.';
      header('location:' . SITEURL . 'admin/login.php');
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
  }
}
?>

<html>
  <head>
    <title>Login - System zamówienia jedzenia</title>
    <link rel="stylesheet" href="../css/admin.css">
  </head>

  <body>
    <div class="login">
      <h1 class="text-center">Login władcy</h1>
      <br><br>

      <?php 
        if (isset($_SESSION['login_error'])) {
          echo '<div class="error text-center">' . $_SESSION['login_error'] . '</div>';
          unset($_SESSION['login_error']);
        }
      ?>


      <form action="" method="POST" class="text-center">
        Nazwa użytkownika: <br>
        <input type="text" name="username" placeholder="Nazwa"><br><br>

        Hasło: <br>
        <input type="password" name="password" placeholder="Hasło"><br><br>

        <input type="submit" name="submit" value="Login" class="btn-primary">
      </form>
    </div>
  </body>
</html>
