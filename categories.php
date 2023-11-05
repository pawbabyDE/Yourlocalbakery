<?php include('partials-front/menu.php'); ?>

<!-- Sekcja kategorii -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Nasza oferta</h2><!--Do potencjalnej zmiany placeholdera, kategorie zamówień-->

        <?php
        // Show all active categories
        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $title = htmlspecialchars($row['title']); // Use htmlspecialchars to prevent XSS

                $image_name = $row['image_name'];
        ?>

                <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        if ($image_name == "") {
                            //Error 404 na zdjęcia
                            echo "<div class='error'>Error 404. Zdjęcie nie znalezione</div>";
                        } else {
                        //Errorn't
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                        <?php
                        }
                        ?>

                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>

        <?php
            }

            mysqli_stmt_close($stmt);
        } else {
            // Error handling
            echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- I tu się kończą -->


<?php include('partials-front/footer.php'); ?>
