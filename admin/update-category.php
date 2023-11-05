<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Aktualizacja kategorii</h1>

        <br><br>


        <?php 
        
            //Sprawdź czy ID jest ustawione
            if(isset($_GET['id']))
            {
                //Zbierz ID wszystkich kategorii
                //echo "Zbieram ";
                $id = $_GET['id'];
                //Stwórz query w tym celu
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                //Wykonaj query
                $res = mysqli_query($conn, $sql);

                //Policz wiersze
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Zbierz dane
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //redirect 
                    $_SESSION['no-category-found'] = "<div class='error'>Kategoria nie została znaleziona</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
            else
            {
                //redirect 
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Tytuł: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Aktualne zdjecie: </td>
                    <td>
                        <?php 
                            if($current_image != "")
                            {
                                //Pokaż zdj
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Pokaż wiadomość
                                echo "<div class='error'>Zdjęcie nie zostało dodane.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Nowe zdjęcie : </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Wyróżnione: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Tak

                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> Nie
                    </td>
                </tr>

                <tr>
                    <td>Aktywne: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Tak 

                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> Nie
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {
                //echo "Kliknięte";
                //1. Zbierz dane z formularza
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Wrzucanie nowego zdj jeśli jest wybrane
                //Sprawdź czy jest wybrane
                if(isset($_FILES['image']['name']))
                {
                    //Zbierz dane zdj 
                    $image_name = $_FILES['image']['name'];

                    //Sprawdź czy zdj jest dostępnę
                    if($image_name != "")
                    {
                        //Zdj jest dostępne

                        //A. Wrzuć nowe zdj

                        //Rename zdj 
                        //Zbieramy rozszerzenie pliku
                        $ext = end(explode('.', $image_name));

                        //Rename zdj
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; 
                        

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //W końcu wrzucamy to zdj 
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Sprawdź if zdj jest uploaded
                        //Jeśli nie jest to error i haltujemy proces
                        if($upload==false)
                        {
                            //SEt message
                            $_SESSION['upload'] = "<div class='error'>Nie udało się wrzucić zdjęcia. </div>";
                            //Redirect
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //die.
                            die();
                        }

                        //B. Usuń aktualne zdjęcie 
                        if($current_image!="")
                        {
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);

                            //Sprawdź czy usunięte
                            //Jeśli error to pokaż wiad i haltujemy
                            if($remove==false)
                            {
                                //Error
                                $_SESSION['failed-remove'] = "<div class='error'>Nie udało się usunąć zdjęcia </div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();//die.
                            }
                        }
                        

                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //3. Zaktualizuj bazę danych.
                $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active' 
                    WHERE id=$id
                ";

                //Wykonaj query
                $res2 = mysqli_query($conn, $sql2);

                //4. Redirect z wiadomością
                //Sprawdź czy się wykonało
                if($res2==true)
                {
                    //Kategoria zaktualizowana
                    $_SESSION['update'] = "<div class='success'>Kategoria została zaktualizowana.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Nie udało sie zaktualizować kategorii
                    $_SESSION['update'] = "<div class='error'>Nie udało się zktualizować kategorii.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>