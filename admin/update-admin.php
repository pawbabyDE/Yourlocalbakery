<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Zaktualizuj Admina</h1>

        <br><br>

        <?php 
            // 1. Weź ID konkretnego admina
            $id = $_GET['id'];

            // 2. Stwórz query w tym celu
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";

            // Wykonaj query
            $res = mysqli_query($conn, $sql);

            // Sprawdź czy się wykonało
            if ($res == true) {
                // Sprawdź czy jest w bazie
                $count = mysqli_num_rows($res);

                // Sprawdź czy mamy dane admina
                if ($count == 1) {
                    // Zbierz dane
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                } else {
                    // Redirect do zarządzania adminem
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Imię i nazwisko: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Nazwa użytkownika: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
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
        $full_name = htmlspecialchars($_POST['full_name'], ENT_QUOTES, 'UTF-8'); // Sanitize input
        $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'); // Sanitize input

        // Ustaw query aby wrzuciło do bazy
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username' 
        WHERE id='$id'
        ";

        // Wykonaj Query
        $res = mysqli_query($conn, $sql);

        // Sprawdź czy się wykonało
        if ($res == true) {
            // Wykonało się i admin zaktualizowany
            $_SESSION['update'] = "<div class='success'>Admin został zaktualizowany.</div>";
            // Redirect 
            header('location:' . SITEURL . 'admin/manage-admin.php');
        } else {
            // Nie udało się 
            $_SESSION['update'] = "<div class='error'>Nie udało się zaktualizować admina.</div>";
            // Redirect 
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }

?>

<?php include('partials/footer.php'); ?>