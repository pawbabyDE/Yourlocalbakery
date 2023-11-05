<?php 
    //Rozpocznij sesje 
    session_start();


    //Utwórz stałe aby nie były one powtarzalne
    define('SITEURL', 'http://localhost/onlinefood-order/'); //URL strony
    define('LOCALHOST', 'localhost'); //localhost = adres potencjalnego serwera
    define('DB_USERNAME', 'root'); //usr do DB
    define('DB_PASSWORD', ''); //pwd do DB 
    define('DB_NAME', 'onlinefoodorder'); //nazwa DB
    
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die("Connection failed: " . mysqli_error($conn)); //łączenie z bazą danych, albo przejdzie albo łącze zdycha
    $db_select = mysqli_select_db($conn, DB_NAME) or die("Database selection failed: " . mysqli_error($conn)); //Wybieranie bazy danych. jak nie znajdzie tej z linijki 11 to połączenie zdycha


?>