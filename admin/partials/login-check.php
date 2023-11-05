<?php 

    //Sprawdź czy user jest lognięty
    if(!isset($_SESSION['user'])) //czy sesja jest ustawiona
    {
        //User nie jest logniety
        //Redirect z wiadomościa
        $_SESSION['no-login-message'] = "<div class='error text-center'>Lognij się byku, a nie admina strugasz.</div>";
        //Redirect
        header('location:'.SITEURL.'admin/login.php');
    }

?>