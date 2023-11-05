<?php 

    include('../config/constants.php'); 
    include('login-check.php');

?>


<html>
    <head>
        <title>Online Food Order</title>

        <link rel="stylesheet" href="../css/admin.css">
    </head>
    
    <body>
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Panel władcy</a></li>
                    <li><a href="manage-category.php">Kategorie</a></li>
                    <li><a href="manage-food.php">Jedzenie</a></li>
                    <li><a href="manage-order.php">Wybór zamówień</a></li>
                    <li><a href="manage-admin.php">Zarządzaj adminami</a></li>
                    <li><a href="logout.php">Porzuć swe konto.</a></li>
                </ul>
            </div>
        </div>
        