
    <?php include('partials-front/menu.php'); ?>

    <!-- Sekcja szukania jedzenia -->
    <section class="food-search text-center">
        <div class="container">
            <?php 

                //Zbierz z paska czego szukasz
                $search = $_POST['search'];
            
            ?>


            <h2><a href="#" class="text-white">Żarło "<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- Koniec -->



    <!-- Sekcja menu jedzenia -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu</h2>

            <?php 

                //Zapytanie SQL aby znalazło jedzenie bazując na tym co wyszukujesz
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //Wykonaj zapytanie
                $res = mysqli_query($conn, $sql);

                //Policz wiersze
                $count = mysqli_num_rows($res);

                //Sprawdza czy dostępne
                if($count>0)
                {
                    //Dostępne
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Pokaż mi swoje towary(sprawdza detale zamówienia)
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    //Sprawdź czy nie ma 404 na zdj
                                    if($image_name=="")
                                    {
                                        //Jest 404 
                                        echo "<div class='error'>Image not Available.</div>";
                                    }
                                    else
                                    {
                                        //Errorn't 
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
                    //Nie znaleziono jedzenia
                    echo "<div class='error'>Nie znaleziono Żarła.</div>";
                }
            
            ?>

            

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- Koniec -->

    <?php include('partials-front/footer.php'); ?>