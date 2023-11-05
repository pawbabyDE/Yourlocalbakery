<?php include('partials-front/menu.php'); ?>

<!-- Sekcja szukania jedzenia -->
<section class="food-search text-center">
    <div class="container">
        <?php 
            
            //Zbierz z paska czego szukasz
            // Collect the user's search query from the input field
            $search = $_POST['search'];
        
        ?>


        <h2><a href="#" class="text-white">Żarło "<?php echo $search; ?>"</a></h2> <!--Trzeba ustalić gdzie to  konkretnie jest & zmienić -->

    </div>
</section>
<!-- Koniec -->

<!-- Sekcja menu jedzenia -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>

        <?php 
            //Zapytanie SQL aby znalazło jedzenie bazując na tym co wyszukujesz
            // SQL query to find food items based on user's search query
            // In short, it retrieves data from the 'tbl_food' table where the title or description is similar or identical to the user's search
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            //Wykonaj zapytanie
            // Connects to the database and sends the query
            $res = mysqli_query($conn, $sql);

            //Policz wiersze
            // idk why the fuck it is here. but it seems like it has to be here no matter fucking what
            $count = mysqli_num_rows($res);

            // Sprawdza czy dostępne
            // idfk why but okay. doesn't matter why, what matters is that it fucking works
            if($count>0)
            {
                // Dostępne
                while($row=mysqli_fetch_assoc($res))
                {
                    // Pokaż mi swoje towary(sprawdza detale zamówienia)
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                // Sprawdź czy nie ma 404 na zdj
                                if($image_name=="")
                                {
                                    // Jest 404 
                                    echo "<div class='error'>Image not Available.</div>";
                                }
                                else
                                {
                                    // Errorn't 
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
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
            }
            else
            {
                // Nie znaleziono jedzenia
                echo "<div class='error'>Nie znaleziono Żarła.</div>";
            }
        
        ?>

        <div class="clearfix"></div>

    </div>
</section>
<!-- Koniec -->

<?php include('partials-front/footer.php'); ?>
