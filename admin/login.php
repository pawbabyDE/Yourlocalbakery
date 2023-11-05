<?php
include('../config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM tbl_admin WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];

        // Verify the password using password_hash
        if (password_verify($password, $db_password)) {
            // Password matches, set session and redirect
            $_SESSION['login'] = "<div class='success'>Zalogowane.</div>";
            $_SESSION['user'] = $username;
            header('location:' . SITEURL . 'admin/');
        } else {
            // Password does not match
            $_SESSION['login'] = "<div class='error text-center'>Dane jakie zostały wprowadzone nie pasują</div>";
            header('location:' . SITEURL . 'admin/login.php');
        }
    } else {
        // User not found
        $_SESSION['login'] = "<div class='error text-center'>Dane jakie zostały wprowadzone nie pasują</div>";
        header('location:' . SITEURL . 'admin/login.php');
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
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
                if(isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message'])) {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>


            <!-- formularz lgoowania -->
            <form action="" method="POST" class="text-center">
                Nazwa użytkownika: <br>
                <input type="text" name="username" placeholder="Nazwa"><br><br>

                Hasło: <br>
                <input type="password" name="password" placeholder="Hasło"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>
            </form>
<!-- End-->

            
        </div>
    </body>
</html>
