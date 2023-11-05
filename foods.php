
    <?php include('partials-front/menu.php'); ?>

    <!-- Sekcja szukania jedzenia -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Szukaj Żarła.." required>
                <input type="submit" name="submit" value="Szukaj" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Koniec -->



    <!-- Sekcja menu jedzenia -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu</h2>

            <?php 
                // Jedzenie które ma atrybut active
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

                //Wykonaj zapytanie
                $res=mysqli_query($conn, $sql);

                //Policz wiersze
                $count = mysqli_num_rows($res);

                //Zobacz czy dostępne or not
                if($count>0)
                {
                    //Dostępne
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Pokaż mi swoje towary (pokaż info)
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        ?>
                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    //Sprawdź czy jest 404 na zdj 
                                    if($image_name=="")
                                    {
                                        //Error 404
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
                                <p class="food-price">zł,<?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Zamów Teraz</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    //Jedzenie nie dostępne
                    echo "<div class='error'>Jedzenie nie jest dostępne.</div>";
                }
            ?>

            

            

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- Koniec -->

    <?php include('partials-front/footer.php'); ?>