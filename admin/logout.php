<?php 
    //Inc constants.php tutaj
    include('../config/constants.php');
    //1.Usuń sesję
    session_destroy(); //Unsets $_SESSION['user']

    //2. Redirect
    header('location:'.SITEURL.'admin/login.php');

?>