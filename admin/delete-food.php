<?php 
    //Inc constants.php tutaj
    include('../config/constants.php');

    //echo "Usuń stronę z jedzeniem";

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Przetwórz by usunąć
        //echo "Przetwórz by usunąć";

        //1. Zbierz ID i nazwę zdj 
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Usuń zdj jak możliwe
        //Sprawdż czy dostępne, i usuń tylko jeśli nie jest.
        if($image_name != "")
        {
            // To ma zdj i trzeba je usunąć
            //Znajdź ścieżkę tego zdj
            $path = "../images/food/".$image_name;

            //Usuń zdj z folderu
            $remove = unlink($path);

            //Sprawdź czy usunięte
            if($remove==false)
            {
                //Nie usunęło
                $_SESSION['upload'] = "<div class='error'>Nie udało się usunąc </div>";
                //Redirect
                header('location:'.SITEURL.'admin/manage-food.php');
                //die.
                die();
            }

        }

        //3. Usuń jedzenie z bazy danych.
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //Wykonaj Query
        $res = mysqli_query($conn, $sql);

        //Zobacz czy wykonane i ustaw odpowiednią wiadomość
        //4. Redirect z wiadomością
        if($res==true)
        {
            //Usunięte  
            $_SESSION['delete'] = "<div class='success'>Jedzenie zostało usunięte</div>";\
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Nie udało się 
            $_SESSION['delete'] = "<div class='error'>Nie udało się usunąć jedzenia.</div>";\
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        

    }
    else
    {
        //Redirect
        //echo "Redirect";
        $_SESSION['unauthorize'] = "<div class='error'>Error 403 </div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>