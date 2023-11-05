<?php include('partials-front/menu.php'); ?>

<?php
// Check if the category ID is set
if (isset($_GET['category_id'])) {
    // It's set, so retrieve it
    $category_id = $_GET['category_id'];
    
    // Retrieve the category title based on the ID using prepared statements
    $sql = "SELECT title FROM tbl_category WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $category_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_assoc($result);
        $category_title = htmlspecialchars($row['title']); // Escape output to prevent XSS
    } else {
        // Error handling
        echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
    }
} else {
    // Redirect to the main page
    header('location:' . SITEURL);
}
?>

<!-- Food Search Section -->
<section class="food-search text-center">
    <div class="container">
        <h2><a href="#" class="text-white">Foods on "<?php echo $category_title; ?>"</a></h2>
    </div>
</section>

<!-- Food Menu Section -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>

        <?php
        // Create a SQL query to fetch food items based on the category
        $sql2 = "SELECT * FROM tbl_food WHERE category_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);

        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, "i", $category_id);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);

            // Check if food items are available
            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $id = $row2['id'];
                    $title = htmlspecialchars($row2['title']); // Escape output to prevent XSS
                    $price = $row2['price'];
                    $description = htmlspecialchars($row2['description']); // Escape output to prevent XSS
                    $image_name = $row2['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if (empty($image_name)) {
                                echo "<div class='error'>Error 404. Zdjęcie nie znalezione.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Zamów teraz</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<div class='error'>Jedzenie nie jest dostępne.</div>";
            }
        } else {
            // Error handling
            echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
