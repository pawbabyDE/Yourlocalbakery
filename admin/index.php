<?php 
    // Include 'partials/menu.php' here
    include('partials/menu.php');
?>
<?php
session_start();

if (!isset($_SESSION['login'])) {
  // Redirect the user to the login page if they are not logged in
  header('location:' . SITEURL . 'admin/login.php');
  exit;
}

// Display the admin index page
echo 'You are logged in!';
?>
<!-- Start of the main content -->
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
                // SQL query
                $sql = "SELECT * FROM tbl_category";
                // Execute Query
                $res = mysqli_query($conn, $sql);
                // Count rows
                $count = mysqli_num_rows($res);
            ?>
            <h1><?php echo $count; ?></h1>
            <br />
            Kategorie jedzenia
        </div>

        <div class="col-4 text-center">
            <?php 
                // SQL query
                $sql2 = "SELECT * FROM tbl_food";
                // Execute Query
                $res2 = mysqli_query($conn, $sql2);
                // Count rows
                $count2 = mysqli_num_rows($res2);
            ?>
            <h1><?php echo $count2; ?></h1>
            <br />
            Jedzenie
        </div>

        <div class="col-4 text-center">
            <?php 
                // SQL query
                $sql3 = "SELECT * FROM tbl_order";
                // Execute Query
                $res3 = mysqli_query($conn, $sql3);
                // Count rows
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
                // Execute query
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
                // SQL query
                $sql6 = "SELECT * FROM tbl_order WHERE status = 'Ordered'";
                // Execute Query
                $res6 = mysqli_query($conn, $sql6);
                // Count rows
                $count6 = mysqli_num_rows($res6);
            ?>
            <h1><?php echo $count6; ?></h1>
            <br />
            Oczekujące zamówienia
        </div>

        <div class="col-4 text-center">
            <?php 
                // SQL query
                $sql7 = "SELECT * FROM tbl_order WHERE status = 'On Delivery'";
                // Execute Query
                $res7 = mysqli_query($conn, $sql7);
                // Count rows
                $count7 = mysqli_num_rows($res7);
            ?>
            <h1><?php echo $count7; ?></h1>
            <br />
            Zamówienia wysłane
        </div>

        <div class="col-4 text-center">
            <?php 
                // SQL query
                $sql7 = "SELECT * FROM tbl_order WHERE status = 'Cancelled'";
                // Execute Query
                $res7 = mysqli_query($conn, $sql7);
                // Count rows
                $count7 = mysqli_num_rows($res7);
            ?>
            <h1><?php echo $count7; ?></h1>
            <br />
            Zamówienia anulowane
        </div>

        <div class="col-4 text-center">
            <?php 
                // SQL query
                $sql8 = "SELECT * FROM tbl_admin";
                // Execute Query
                $res8 = mysqli_query($conn, $sql8);
                // Count rows
                $count8 = mysqli_num_rows($res8);
            ?>
            <h1><?php echo $count8; ?></h1>
            <br />
            SysAdmin
        </div>

        <div class="clearfix"></div>
    </div>
</div>
<!-- End of main content -->

<?php include('partials/footer.php'); ?>
