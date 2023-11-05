<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        
            <table class="tbl-30">

                <tr>
                    <td>Nazwa: </td>
                    <td>
                        <input type="text" name="title" placeholder="Nazwa jedzenia">
                    </td>
                </tr>

                <tr>
                    <td>Opis: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Opis jedzenia."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Cena: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Wybierz zdjęcie : </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Kategoria: </td>
                    <td>
                        <select name="category">

                            <?php 
                                //tworzymy kod PHP do wyświetlania kategorii z DB
                                //1. Ustaw query aby zebrało z bazy
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                
                                //Wykonaj Query
                                $res = mysqli_query($conn, $sql);

                                //Policz rzędy
                                $count = mysqli_num_rows($res);

                                //if >0 to dobrze, else coś się zepsuło 
                                if($count>0)
                                {
                                    // >0 jest
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //Zbierz detale kategorii
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //=<0 jest
                                    ?>
                                    <option value="0">Nie znaleziono kategorii</option>
                                    <?php
                                }
                            

                                //2. Display on Drpopdown
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Wyróżnione: </td>
                    <td>
                        <input type="radio" name="featured" value="tak"> Tak
                        <input type="radio" name="featured" value="Nie"> Nie
                    </td>
                </tr>

                <tr>
                    <td>Aktywne: </td>
                    <td>
                        <input type="radio" name="active" value="Tak"> Tak
                        <input type="radio" name="active" value="Nie "> Nie
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Dodaj jedzenie" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        
        <?php 

            //Sprawdź czy guzik jest wciśnięty

            if(isset($_POST['submit']))
            {
                //Dodaj jedzenie do bazy
                //echo "Kliknięted";
                
                //1. Zbierz dane z formularza
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                        //Sprawdź czy guzik jest wciśnięty
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //Ustaw domyślne
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //Ustaw domyślne
                }

                //2. Upload zdj jak wybierzesz
                //Sprawdź czy selected, jeśli tak to upload
                if(isset($_FILES['image']['name']))
                {
                    //Zbierz info o zdj
                    $image_name = $_FILES['image']['name'];

                    //Sprawdź czy selected, jeśli tak to upload
                    if($image_name!="")
                    {
                        //Wybraned
                        //A. Rename zdj
                        //Zbierz rozszerzenie pliku (jpg, png, gif, i pozostałe)
                        $ext = end(explode('.', $image_name));

                        // Nowa nazwa dla zdj 
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; 

                        //B.Upload zdj
                        //Zbierz info o zdj

                        // Źródło to aktualna ścieżka 
                        $src = $_FILES['image']['tmp_name'];

                        //Ścieżka docelowa
                        $dst = "../images/food/".$image_name;

                        //W końcu upload
                        $upload = move_uploaded_file($src, $dst);

                        //Zobacz czy uploaded
                        if($upload==false)
                        {
                            //Error wyszedł
                            //Redirect
                            $_SESSION['upload'] = "<div class='error'>Nie wysłało się zdj, sprawdź neta lub kod.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //die.
                            die();
                        }

                    }

                }
                else
                {
                    $image_name = ""; //default jako puste.
                }

                //3.Wsadź do bazy

                //Ustaw query aby wrzuciło do bazy jedzenie
                $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";

                //Wykonaj Query
                $res2 = mysqli_query($conn, $sql2);

                //Sprawdź czy wrzuciło do bazy
                //4. Redirect do zarządzania
                if($res2 == true)
                {
                    //Wrzuciło prawidłowo
                    $_SESSION['add'] = "<div class='success'>Jedzenie zostało dodane</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Błąd w wrzucaniu
                    $_SESSION['add'] = "<div class='error'>Jedzenie nie zostało wrzucone.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                
            }

        ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>