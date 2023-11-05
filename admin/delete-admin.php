<?php 
    // Include constants.php here
    include('../config/constants.php');

    // 1. Weź ID admina do usunięcia
    $id = $_GET['id'];

    // 2. Ustaw query aby usunęło z bazy
    $sql = "DELETE FROM tbl_admin WHERE id = $id";

    // Wykonaj Query
    $res = mysqli_query($conn, $sql);

    // Sprawdź czy się wykonało
    if ($res == true) {
        // Query wykonane i admin usunięty
        // echo "Admin usunięty";
        // Utwórz zmienną sesji aby wyświetlić wiadomości
        $_SESSION['delete'] = "<div class='success'>Admin usunięty</div>";
        // Redirect do admina
        header('location:'.SITEURL.'admin/manage-admin.php');
    } else {
        // Admin nie usunięty
        // echo "Admin nie usunięty";

        $_SESSION['delete'] = "<div class='error'>Admin nie usunięty.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
?>