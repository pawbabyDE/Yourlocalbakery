<?php 
    // Include constants.php here
    include('../config/constants.php');

    // echo "Usuń stronę ";
    // Sprawdź ID i image_name
    if (isset($_GET['id']) AND isset($_GET['image_name'])) {
        // Bierz wartość i usuń
        // echo "Bierz wartość i usuń";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Usuń zdj z dysku/FTP
        if ($image_name != "") {
            // Zdj dostępne - usuwamy
            $path = "../images/category/".$image_name;
            // Usuń
            $remove = unlink($path);

            // Nie usunięte, przerywamy proces
            if ($remove == false) {
                // Ustaw wiadomość sesji
                $_SESSION['remove'] = "<div class='error'>Nie udało się usunąć zdj z kategorii</div>";
                // Redirect do kategorii
                header('location:'.SITEURL.'admin/manage-category.php');
                // die.
                die();
            }
        }

        // Usuń dane z bazy
        // Ustaw query aby usunęło z bazy
        $sql = "DELETE FROM tbl_category WHERE id = $id";

        // Wykonaj Query
        $res = mysqli_query($conn, $sql);

        // Sprawdź czy się wykonało
        if ($res == true) {
            // Ustaw że tak i przekieruj
            $_SESSION['delete'] = "<div class='success'>Usunięte prawidłowo</div>";
            // Redirect
            header('location:'.SITEURL.'admin/manage-category.php');
        } else {
            // Ustaw że nie i przekieruj
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
            // Redirect
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    } else {
        // Redirect
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>
