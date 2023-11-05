<?php 
    //Rozpocznij sesje 
    session_start();


    //Utwórz stałe aby nie były one powtarzalne
    define('SITEURL', 'http://localhost/onlinefood-order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'onlinefoodorder');
    
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //łączenie z bazą danych
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); //Wybieranie bazy danych


?>