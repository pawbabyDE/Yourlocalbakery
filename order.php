
<?php include('partials-front/menu.php'); ?>

    <?php 
        //Sprawdź czy jest ustawione ID dla jedzenia
        if(isset($_GET['food_id']))
        {
            //Weź ID jedzenia i jego detale 
            $food_id = $_GET['food_id'];

            //Zbierz detale jedzenia
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            //Wykonaj zapytanie
            $res = mysqli_query($conn, $sql);
            //Policz wiersze
            $count = mysqli_num_rows($res);
            //Zobacz czy info jest dostepne or not
            if($count==1)
            {
                //Mamy dane, to je bierzemy z bazy
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                //Jedzenie nie jest dostępne
                //Redirect na główną 
                header('location:'.SITEURL);
            }
        }
        else
        {
            //Redirect na główną 
            header('location:'.SITEURL);
        }
    ?>

    <!-- Sekcja wyszukiwania jedzenia -->
    <section class="food-search2">
        <div class="container">
            
            <h2 class="text-center text-white">Wypełnij To Pole by Zamówić Jedzonkoooo.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Twój Wybór</legend>

                    <div class="food-menu-img">
                        <?php 
                        
                            //Zobacz czy jest 404 na zdj or not 
                            if($image_name=="")
                            {
                                //Error 404 na zdj 
                                echo "<div class='error'>Error 404. Zdjęcie nie znalezione</div>";
                            }
                            else
                            {
                                //Errorn't
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
                    <legend>INFORMACJE</legend>
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

                //Zobacz czy guzik wciśnięty
                if(isset($_POST['submit']))
                {
                    // Zdobądź info z formularza

                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; // KWota = cena * ilość

                    $order_date = date("Y-m-d h:i:sa"); //Data zamówienia 

                    $status = "Ordered";  // Zamówione, W dostawie, Dostarczone, Anulowane

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];


                    //Zapisz w bazie
                    //Zapytanie SQL by zapisać w bazie 
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

                    //echo $sql2; die();

                    //Wykonaj zapytanie
                    $res2 = mysqli_query($conn, $sql2);

                    //Zobacz czy przeszło czy odrzuciło
                    if($res2==true)
                    {
                        //Przeszło
                        $_SESSION['order'] = "<div class='success text-center'>Zamówioned.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Odrzuciło
                        $_SESSION['order'] = "<div class='error text-center'>Nie zamówiło się </div>";
                        header('location:'.SITEURL);
                    }

                }
            
            ?>

        </div>
    </section>
    <!-- Koniec -->

    <?php include('partials-front/footer.php'); ?>