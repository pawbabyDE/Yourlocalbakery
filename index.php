<?php include('partials-front/menu.php'); ?>

<!-- Food Search Section -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Szukaj łakoci" required> <!-- Do potencjalnej zmiany placeholdera-->
            <input type="submit" name="submit" value="Szukaj" class="btn btn-primary">
        </form>
    </div>
</section>

<!-- Food Menu Section -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>

        <?php
        // Query to select active food items
        $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check if any rows were returned
        if ($res) {
            // Get the row count
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = htmlspecialchars($row['title']); // Escape output to prevent XSS
                    $description = htmlspecialchars($row['description']); // Escape output to prevent XSS
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if (empty($image_name)) {
                                echo "<div class='error'>Image not Available.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">zł<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Zamów Teraz</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                // No available food items
                echo "<div class='error'>Jedzenie nie jest dostępne.</div>";
            }
        } else {
            // Error handling
            echo "<div class='error'>Wystąpił błąd podczas ładowania danych.</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
