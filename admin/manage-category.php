<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Zarządzaj kategoriami jedzenia</h1>
        <br /><br />
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['no-category-found'])) {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        ?>
        <br /><br>
        <!-- Button do dodania admina -->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Dodaj kategorię</a>
        <br /><br /><br />
        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Zdjęcie</th>
                <th>Wyróżnione</th>
                <th>Aktywne</th>
                <th>Akcje</th>
            </tr>
            <?php
            // Use prepared statements to retrieve all categories from the database
            $sql = "SELECT * FROM tbl_category";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $sn = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            ?>
                <tr>
                    <td><?php echo $sn++; ?>.</td>
                    <td><?php echo $title; ?></td>
                    <td>
                        <?php
                        if ($image_name != "") {
                            // Display the image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px">
                        <?php
                        } else {
                            // Display an error message
                            echo "<div class='error'>Zdjęcie nie jest dodane.</div>";
                        }
                        ?>
                    </td>
                    <td><?php echo $featured; ?></td>
                    <td><?php echo $active; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Zaktualizuj kategorię</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Usuń kategorię</a>

                    </td>
                </tr>
            <?php
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
