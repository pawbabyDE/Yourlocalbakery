<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Zmień hasło</h1>
        <br><br>

        <?php 
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Aktualne hasło: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Aktualne hasło">
                    </td>
                </tr>

                <tr>
                    <td>Nowe hasło:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="Nowe hasło">
                    </td>
                </tr>

                <tr>
                    <td>Potwierdź hasło: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Potwierdź hasło">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Zmień hasło" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    // Sprawdź czy guzik jest wciśnięty
    if (isset($_POST['submit'])) {
        // Zbierz dane z formularza
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // Sprawdź czy nowe hasło i potwierdzenie są zgodne
        if ($new_password == $confirm_password) {
            // Sprawdź czy użytkownik istnieje w bazie i hasło się zgadza
            $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
            $res = mysqli_query($conn, $sql);

            if ($res == true) {
                // Sprawdź czy użytkownik istnieje
                $count = mysqli_num_rows($res);

                if ($count == 1) {
                    // Użytkownik istnieje i można zmienić hasło
                    $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id=$id";
                    $res2 = mysqli_query($conn, $sql2);

                    if ($res2 == true) {
                        // Hasło zaktualizowane pomyślnie
                        $_SESSION['change-pwd'] = "<div class='success'>Hasło zostało zmienione. </div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    } else {
                        // Błąd podczas aktualizacji hasła
                        $_SESSION['change-pwd'] = "<div class='error'>Nie udało się zmienić hasła. </div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                } else {
                    // Użytkownik nie istnieje
                    $_SESSION['user-not-found'] = "<div class='error'>Nie znaleziono użytkownika </div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        } else {
            // Hasła nie zgadzają się
            $_SESSION['pwd-not-match'] = "<div class='error'> Hasła się nie zgadzają.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
?>

<?php include('partials/footer.php'); ?>
