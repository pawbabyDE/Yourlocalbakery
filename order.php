<?php include('partials-front/menu.php'); ?>

<?php 
    // Check if 'food_id' is set in the URL
    if(isset($_GET['food_id']))
    {
        // Retrieve 'food_id' and its details
        $food_id = $_GET['food_id'];

        // Fetch food details from the database based on 'food_id'
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        // Execute the SQL query
        $res = mysqli_query($conn, $sql);
        // Count the rows
        $count = mysqli_num_rows($res);
        // Check if the information is available or not
        if($count == 1)
        {
            // Data is available, so retrieve it from the database
            $row = mysqli_fetch_assoc($res);

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
        else
        {
            // Food is not available, redirect to the homepage
            header('location:'.SITEURL);
        }
    }
    else
    {
        // Redirect to the homepage if 'food_id' is not set
        header('location:'.SITEURL);
    }
?>

<!-- Order Food Section -->
<!-- Section for ordering food -->
<section class="food-search2">
    <div class="container">
        
        <h2 class="text-center text-white">Wypełnij To Pole by Zamówić Jedzonkoooo.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Your Choice</legend>

                <div class="food-menu-img">
                    <?php 
                        // Check if there's a 404 error on the image
                        if($image_name == "")
                        {
                            // Display an error for image not found
                            echo "<div class='error'>Error 404. Zdjęcie nie znalezione</div>";
                        }
                        else
                        {
                            // Display the food image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Hawajska z kurczakiem" class="img-responsive img-curve">
                            <?php
                        }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">

                    <p class="food-price">zł<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Ilość</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                    
                </div>
            </fieldset>
            
            <fieldset>
                <legend>INFORMATION</legend>
                <div class="order-label">Imię i Nazwisko</div>
                <input type="text" name="full-name" placeholder="N.p Jan Kowalski" class="input-responsive" required>

                <div class="order-label">Numer Telefonu</div>
                <input type="tel" name="contact" placeholder="N.p 213700000" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="N.p. PJ@gmail.com" class="input-responsive" required>

                <div class="order-label">Adres</div>
                <textarea name="address" rows="10" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Zamów" class="btn btn-primary">
            </fieldset>
        </form>

        <?php 
            // Check if the 'submit' button is clicked
            if(isset($_POST['submit']))
            {
                // Get information from the form
                $food = $_POST['food'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty; // Calculate the total amount

                $order_date = date("Y-m-d h:i:sa"); // Order date

                $status = "Ordered"; // Order status: Ordered, In Delivery, Delivered, Canceled

                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];

                // Save the order in the database
                // SQL query to insert the order into the database 
                $sql2 = "INSERT INTO tbl_order SET 
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                ";

                // Execute the SQL query
                $res2 = mysqli_query($conn, $sql2);

                // Check if the query was successful or not
                if($res2 == true)
                {
                    // Order placed successfully
                    $_SESSION['order'] = "<div class='success text-center'>Zamówiono.</div>";
                    header('location:'.SITEURL);
                }
                else
                {
                    // Order failed
                    $_SESSION['order'] = "<div class='error text-center'>Nie udało się zamówić.</div>";
                    header('location:'.SITEURL);
                }
            }
        ?>
    </div>
</section>
<!-- End of Order Food Section -->

<?php include('partials-front/footer.php'); ?>
