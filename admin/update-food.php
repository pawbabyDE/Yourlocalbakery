<?php include('partials/menu.php'); ?>

<?php 
    //Sprawdź czy ID jest ustawione
    if(isset($_GET['id']))
    {
        //Zbierz wszystkie ID
        $id = $_GET['id'];

        //Robimy query
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //Wykonaj query
        $res2 = mysqli_query($conn, $sql2);

        //Zbierz dane z query
        $row2 = mysqli_fetch_assoc($res2);

        //Zbierz poszczególne wartości
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }
    else
    {
        //Redirect 
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

<center>
<div class="main-content">
    <div class="wrapper">
        <h1>Aktualizuj jedzenie</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        
        <table class="tbl-30">

            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Opis: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Aktualne zdjęcie: </td>
                <td>
                    <?php 
                        if($current_image == "")
                        {
                            //Zdj nie dostępne
                            echo "<div class='error'>Zdjęcie nie jest dostępne.</div>";
                        }
                        else
                        {
                            //Zdj dostępne
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Wybierz nowe zdjęcie: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Kategoria: </td>
                <td>
                    <select name="category">

                        <?php 
                            //Query na aktywne kategorie
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //Wykonaj query
                            $res = mysqli_query($conn, $sql);
                            //Policz wiersze
                            $count = mysqli_num_rows($res);

                            //Sprawdź czy dostępne
                            if($count>0)
                            {
                                // dostępne
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    
                                    //echo "<option value='$category_id'>$category_title</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //Nie jest dostępne
                                echo "<option value='0'>Kategoria nie jest dostępna.</option>";
                            }

                        ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>Wyróżnione: </td>
                <td>
                    <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Tak
                    <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> Nie
                </td>
            </tr>

            <tr>
                <td>Aktywne: </td>
                <td>
                    <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Tak
                    <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> Nie
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
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
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Wrzuć zdj jeśli dostępne

                //Sprawdź czy guzik jest wciśnięty
                if(isset($_FILES['image']['name']))
                {
                    //Wciśnięty
                    $image_name = $_FILES['image']['name']; //Nowa nazwa obrazka

                    //Sprawdź czy jest dostępne
                    if($image_name!="")
                    {
                        //Dostępne
                        //A. Wrzucanie nowego zdj

                        //Zmien nazwe
                        $ext = end(explode('.', $image_name)); 

                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; 

                        //Ścieżka źródła & końcowa
                        $src_path = $_FILES['image']['tmp_name']; //Źródło
                        $dest_path = "../images/food/".$image_name; //Końcowa

                        //Upload 
                        $upload = move_uploaded_file($src_path, $dest_path);

                        // Sprawdź czy się wykonało
                        if($upload==false)
                        {
                            //Nie udało się 
                            $_SESSION['upload'] = "<div class='error'>Nie udało się wrzucić nowego obrazka.</div>";
                            //Redirect
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //die.
                            die();
                        }
                        //3. Usuń obrazek jeśli nowy jest wrzucony
                        //B. Usuń obecny jeśli możliwe
                        if($current_image!="")
                        {
                            //Obecny jest dostępny
                            //Usuń obrazek
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //Sprawdź czy sie usuneło
                            if($remove==false)
                            {
                                //Nie udało się 
                                $_SESSION['remove-failed'] = "<div class='error'>Nie udało się usunąć obrazka.</div>";
                                //Redirect
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //die.
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image; //Domyślne jak nie dasz nowego obrazka
                    }
                }
                else
                {
                    $image_name = $current_image; //Domyślne jak jie klikniesz guzika
                }

                

                //4. Zaktualizuj jedzenie w bazie
                $sql3 = "UPDATE tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //Wykonaj Query
                $res3 = mysqli_query($conn, $sql3);

                //Sprawdź czy się wykonało
                if($res3==true)
                {
                    //Wykonane i zaktualizowane
                    $_SESSION['update'] = "<div class='success'>Jedzenie zaktualizowane prawidłowo.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Nie udało sie zaktualizować
                    $_SESSION['update'] = "<div class='error'>Nie udało się zaktualizować jedzenia.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>