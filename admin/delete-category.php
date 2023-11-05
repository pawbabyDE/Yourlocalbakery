<?php 
    //Inc constants.php tutaj
    include('../config/constants.php');

    //echo "Usuń stronę ";
    //Sprawdź ID i image_name
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Bierz wartość i usuń
        //echo "Bierz wartość i usuń";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //usuń zdj z dysku/FTP
        if($image_name != "")
        {
            //zdj dostępne - usuwamty
            $path = "../images/category/".$image_name;
            //usuń
            $remove = unlink($path);

            //Nie usunięte, haltujemy proces
            if($remove==false)
            {
                //Ustaw wiadomość sesji
                $_SESSION['remove'] = "<div class='error'>Nie udało się usunąć zdj z kategorii</div>";
                //Redirect do kategorii
                header('location:'.SITEURL.'admin/manage-category.php');
                //die.
                die();
            }
        }

        //Usuń dane z bazy
        //Ustaw query aby usunęło z bazy
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Wykonaj Query
        $res = mysqli_query($conn, $sql);

        //Sprawdź czy się wykonało
        if($res==true)
        {
            //Ustaw że tak i redirect
            $_SESSION['delete'] = "<div class='success'>Usunięte prawidłowo</div>";
            //Redirect
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Ustaw że nie i redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
            //Redirect
            header('location:'.SITEURL.'admin/manage-category.php');
        }

 

    }
    else
    {
        //redirect
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>