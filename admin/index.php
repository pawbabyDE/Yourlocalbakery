
<?php include('partials/menu.php'); ?>

        <!--Zaczyna się główna część -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Panel Admina I Władcy</h1>
                <br><br>
                <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?>
                <br><br>

                <div class="col-4 text-center">

                    <?php 
                        //SQLowskie query
                        $sql = "SELECT * FROM tbl_category";
                        //Wykonaj Query
                        $res = mysqli_query($conn, $sql);
                        //Policz wiersze
                        $count = mysqli_num_rows($res);
                    ?>

                    <h1><?php echo $count; ?></h1>
                    <br />
                    Kategorie jedzenia
                </div>

                <div class="col-4 text-center">

                    <?php 
                        //SQLowskie query
                        $sql2 = "SELECT * FROM tbl_food";
                        //Wykonaj Query
                        $res2 = mysqli_query($conn, $sql2);
                        //Policz wiersze
                        $count2 = mysqli_num_rows($res2);
                    ?>

                    <h1><?php echo $count2; ?></h1>
                    <br />
                    Jedzenie
                </div>

                <div class="col-4 text-center">
                    
                    <?php 
                        //SQLowskie query
                        $sql3 = "SELECT * FROM tbl_order";
                        //Wykonaj Query
                        $res3 = mysqli_query($conn, $sql3);
                        //Policz wiersze
                        $count3 = mysqli_num_rows($res3);
                    ?>

                    <h1><?php echo $count3; ?></h1>
                    <br />
                    Liczba zamówień
                </div>

                <div class="col-4 text-center">
                    
                    <?php 
                        //Query co liczy ile kasy zarobiliśmy
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                        //Wykonaj query
                        $res4 = mysqli_query($conn, $sql4);

                        //Weź value z bazy
                        $row4 = mysqli_fetch_assoc($res4);
                        
                        //Total zarobek
                        $total_revenue = $row4['Total'];

                    ?>

                    <h1>zł,<?php echo $total_revenue; ?></h1>
                    <br />
                    Zarobek
                </div>

                <div class="col-4 text-center">
                    
                    <?php 
                        //SQLowskie query
                        $sql6 = "SELECT * FROM tbl_order WHERE status = 'Ordered'";
                        //Wykonaj Query
                        $res6 = mysqli_query($conn, $sql6);
                        //Policz wiersze
                        $count6 = mysqli_num_rows($res6);
                    ?>

                    <h1><?php echo $count6; ?></h1>
                    <br />
                    Oczekujące zamówienia
                </div>

                <div class="col-4 text-center">
                    
                    <?php 
                        //SQLowskie query
                        $sql7 = "SELECT * FROM tbl_order WHERE status = 'On Delivery'";
                        //Wykonaj Query
                        $res7 = mysqli_query($conn, $sql7);
                        //Policz wiersze
                        $count7 = mysqli_num_rows($res7);
                    ?>

                    <h1><?php echo $count7; ?></h1>
                    <br />
                    Zamówienia wysłane
                </div>


                <div class="col-4 text-center">
                    
                    <?php 
                        //SQLowskie query
                        $sql7 = "SELECT * FROM tbl_order WHERE status = 'Cancelled'";
                        //Wykonaj Query
                        $res7 = mysqli_query($conn, $sql7);
                        //Policz wiersze
                        $count7 = mysqli_num_rows($res7);
                    ?>

                    <h1><?php echo $count7; ?></h1>
                    <br />
                    Zamówienia anulowane
                </div>


                <div class="col-4 text-center">
                    
                    <?php 
                        //SQLowskie query
                        $sql8 = "SELECT * FROM tbl_admin";
                        //Wykonaj Query
                        $res8 = mysqli_query($conn, $sql8);
                        //Policz wiersze
                        $count8 = mysqli_num_rows($res8);
                    ?>

                    <h1><?php echo $count8; ?></h1>
                    <br />
                    SysAdmin
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Koniec -->

<?php include('partials/footer.php') ?>