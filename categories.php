
<?php include('partials-front/menu.php'); ?>



    <!-- Sekcja kategorii  -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Paczajjj na Menu Biedaku xD</h2>

            <?php 

                //Pokaż wszystkie aktywne kategorie
                //Zapytanie SQL
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                //Wykonanie sql'a
                $res = mysqli_query($conn, $sql);

                //liczenie ilości wierszy
                $count = mysqli_num_rows($res);

                //zobacz czy dostępne czy nie
                if($count>0)
                {
                    //kategorie dostepne
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //zdobywanie wartości
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php 
                                    if($image_name=="")
                                    {
                                        //Error 404 na zdjęcia
                                        echo "<div class='error'>Error 404. Zdjęcie nie znalezione</div>";
                                    }
                                    else
                                    {
                                        //Errorn't
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    //404 na kategorie
                    echo "<div class='error'>Error 404. Kategoria nie znaleziona.</div>";
                }
            
            ?>
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- I tu się kończą -->


    <?php include('partials-front/footer.php'); ?>