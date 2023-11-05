<?php include('partials-front/menu.php'); ?>

<?php
// Check if the search query is set
if (isset($_POST['search'])) {
    // It's set, so retrieve it
    $search = $_POST['search'];
    // Sanitize the search input
    $search = mysqli_real_escape_string($conn, $search);
} else {
    // If the search query is not set, you may want to handle this case (e.g., show an error message).
    // For now, let's set it to an empty string.
    $search = '';
}
?>

<!-- Food Search Section -->
<section class="food-search text-center">
    <div class="container">
        <h2><a href="#" class="text-white">Żarło "<?php echo htmlspecialchars($search); ?>"</a></h2>
    </div>
</section>

<!-- Food Menu Section -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>

        <?php
        // Create an SQL query to find food items based on the user's search query using prepared statements
        $sql = "SELECT * FROM tbl_food WHERE title LIKE ? OR description LIKE ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind the search parameter to the prepared statement
            $searchParam = '%' . $search . '%';
            mysqli_stmt_bind_param($stmt, "ss", $searchParam, $searchParam);

            // Execute the prepared statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Check if food items are available
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Retrieve food item details
                    $id = $row['id'];
                    $title = htmlspecialchars($row['title']); // Escape output to prevent XSS
                    $price = $row['price'];
                    $description = htmlspecialchars($row['description']); // Escape output to prevent XSS
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
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                // No food found
                echo "<div class='error'>Nie znaleziono Żarła.</div>";
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
