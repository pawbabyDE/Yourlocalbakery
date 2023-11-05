<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - System zamówienia jedzenia</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login władcy</h1>
            <br><br>

            <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
        

            <!-- formularz lgoowania -->
            <form action="" method="POST" class="text-center">
            Nazwa użytkownika: <br>
            <input type="text" name="username" placeholder="Nazwa"><br><br>

            Hasło: <br>
            <input type="password" name="password" placeholder="Hasło"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
            </form>
            <!-- End-->

            
        </div>

    </body>
</html>

<?php 

    //Sprawdź czy guzik jest wciśnięty
    if(isset($_POST['submit']))
    {
        //Zacznij nad tym
        //1.Zbierz dane z formularza
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL patrzy czy pasuje
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Wykonaj Query
        $res = mysqli_query($conn, $sql);

        //4. Policz wiersze aby zobaczyć czy istnieje wgl
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User sie zgadza i reszta więc good
            $_SESSION['login'] = "<div class='success'>Zalogowane.</div>";
            $_SESSION['user'] = $username; 

            //Redirect
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User nie dostępny / nie pasuje nic 
            $_SESSION['login'] = "<div class='error text-center'>Dane jakie zostały wprowadzone nie pasują</div>";
            //Redirect na główną
            header('location:'.SITEURL.'admin/login.php');
        }


    }

?>