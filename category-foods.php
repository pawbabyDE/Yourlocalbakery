    
    <?php include('partials-front/menu.php'); ?>

    <?php 
        //Sprawdza cz ID jest ustawione 
        if(isset($_GET['category_id']))
        {
            //Jest ustawione, bierze je
            $category_id = $_GET['category_id'];
            //Zczytuje nazwe bazując na ID
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

            //Wykonuje zapytanie
            $res = mysqli_query($conn, $sql);

            //Bierze info z bazy danych
            $row = mysqli_fetch_assoc($res);
            //Fetchuje tytuł 
            $category_title = $row['title'];
        }
        else
        {
            //404 siadło
            //Redirect na główną 
            header('location:'.SITEURL);
        }
    ?>


    <!-- Sekcja szukania jedzenia -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2><a href="#" class="text-white">Foods on "<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- Koniec tej sekcji -->



    <!-- Sekcja menu  -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu</h2>

            <?php 
            
                //Tworzy zapytanie SQL aby sfetchować jedzenie bazując na kategorii
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                //Wykonuje zapytanie
                $res2 = mysqli_query($conn, $sql2);

                //Liczy rzędy
                $count2 = mysqli_num_rows($res2);

                //Sprawdza czy dostępne
                if($count2>0)
                {
                    //Jedzenie jest dostępne
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>
                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    if($image_name=="")
                                    {
                                        //404 na zdj
                                        echo "<div class='error'>Error 404. Zdjęcie nie znalezione.</div>";
                                    }
                                    else
                                    {
                                        //Errorn't
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza hawajska z kurczakiem" class="img-responsive img-curve">
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
                }
                else
                {
                    //Jedzenie niedostępne
                    echo "<div class='error'>Jedzenie nie jest dostępne.</div>";
                }
            
            ?>

            

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- Koniec-->

    <?php include('partials-front/footer.php'); ?>