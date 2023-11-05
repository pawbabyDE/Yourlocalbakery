<?php include('partials-front/menu.php'); ?>

<?php 
    if(isset($_GET['food_id']))
    {
        $food_id = $_GET['food_id'];

        $sql = "SELECT * FROM tbl_food WHERE id = " . mysqli_real_escape_string($conn, $food_id);
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) == 1)
        {
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
        else
        {
            header('location:'.SITEURL);
        }
    }
    else
    {
        header('location:'.SITEURL);
    }
?>

<!-- Order Food Section -->
<section class="food-search2">
    <div class="container">
        <h2 class="text-center text-white">Wypełnij to pole, aby zamówić jedzenie.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Your Choice</legend>

                <div class="food-menu-img">
                    <?php 
                        if($image_name == "")
                        {
                            echo "<div class='error'>Error 404. Zdjęcie nie znalezione</div>";
                        }
                        else
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
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
            if(isset($_POST['submit']))
            {
                $food = mysqli_real_escape_string($conn, $_POST['food']);
                $price = floatval($_POST['price']);
                $qty = intval($_POST['qty']);

                $total = $price * $qty;
                $order_date = date("Y-m-d h:i:sa");
                $status = "Ordered";

                $customer_name = mysqli_real_escape_string($conn, $_POST['full-name']);
                $customer_contact = mysqli_real_escape_string($conn, $_POST['contact']);
                $customer_email = mysqli_real_escape_string($conn, $_POST['email']);
                $customer_address = mysqli_real_escape_string($conn, $_POST['address']);

                // Use transactions for a safe and atomic operation
                mysqli_begin_transaction($conn);

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

                $res2 = mysqli_query($conn, $sql2);

                if($res2)
                {
                    mysqli_commit($conn); // Commit the transaction
                    $_SESSION['order'] = "<div class='success text-center'>Zamówiono.</div>";
                    header('location:'.SITEURL);
                }
                else
                {
                    mysqli_rollback($conn); // Rollback the transaction
                    $_SESSION['order'] = "<div class='error text-center'>Nie udało się zamówić.</div>";
                    header('location:'.SITEURL);
                }
            }
        ?>
    </div>
</section>
<!-- End of Order Food Section -->

<?php include('partials-front/footer.php'); ?>
