<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Aktualizacja kategorii</h1>

        <br><br>

        <?php 
            // Sprawdź czy ID jest ustawione
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Stwórz query w tym celu
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                // Wykonaj query
                $res = mysqli_query($conn, $sql);

                // Policz wiersze
                $count = mysqli_num_rows($res);

                if ($count == 1) {
                    // Zbierz dane
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } else {
                    // Redirect
                    $_SESSION['no-category-found'] = "<div class='error'>Kategoria nie została znaleziona</div>";
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }
            } else {
                // Redirect
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Tytuł: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Aktualne zdjecie: </td>
                    <td>
                        <?php 
                            if ($current_image != "") {
                                // Pokaż zdj
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            } else {
                                // Pokaż wiadomość
                                echo "<div class='error'>Zdjęcie nie zostało dodane.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Nowe zdjęcie : </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Wyróżnione: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Tak
                        <input <?php if ($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No"> Nie
                    </td>
                </tr>

                <tr>
                    <td>Aktywne: </td>
                    <td>
                        <input <?php if ($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Tak 
                        <input <?php if ($active == "No") {echo "checked";} ?> type="radio" name="active" value="No"> Nie
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
            if (isset($_POST['submit'])) {
                // Zbierz dane z formularza
                $id = $_POST['id'];
                $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8'); // Sanitize input
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // Wrzucanie nowego zdj jeśli jest wybrane
                if (isset($_FILES['image']['name'])) {
                    // Zbierz dane zdj 
                    $image_name = $_FILES['image']['name'];

                    if ($image_name != "") {
                        // Zdj jest dostępne
                        // A. Wrzuć nowe zdj

                        // Rename zdj 
                        $ext = end(explode('.', $image_name)); // Zbieramy rozszerzenie pliku
                        $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/" . $image_name;

                        // Wrzucamy zdj
                        $upload = move_uploaded_file($source_path, $destination_path);

                        if ($upload == false) {
                            // Set message
                            $_SESSION['upload'] = "<div class='error'>Nie udało się wrzucić zdjęcia.</div>";
                            // Redirect
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            die();
                        }

                        // B. Usuń aktualne zdjęcie 
                        if ($current_image != "") {
                            $remove_path = "../images/category/" . $current_image;
                            $remove = unlink($remove_path);

                            if ($remove == false) {
                                // Error
                                $_SESSION['failed-remove'] = "<div class='error'>Nie udało się usunąć zdjęcia.</div>";
                                header('location:' . SITEURL . 'admin/manage-category.php');
                                die();
                            }
                        }
                    } else {
                        $image_name = $current_image;
                    }
                } else {
                    $image_name = $current_image;
                }

                // Zaktualizuj bazę danych.
                $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active' 
                    WHERE id=$id
                ";

                // Wykonaj query
                $res2 = mysqli_query($conn, $sql2);

                // Redirect z wiadomością
                // Sprawdź czy się wykonało
                if ($res2 == true) {
                    // Kategoria zaktualizowana
                    $_SESSION['update'] = "<div class='success'>Kategoria została zaktualizowana.</div>";
                    header('location:' . SITEURL . 'admin/manage-category.php');
                } else {
                    // Nie udało sie zaktualizować kategorii
                    $_SESSION['update'] = "<div class='error'>Nie udało się zaktualizować kategorii.</div>";
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
        