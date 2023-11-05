<?php include('partials/menu.php'); ?>
<center>
<div class="main-content">
    <div class="wrapper">
        <h1>Dodaj Kategorie</h1>

        <br><br>

        <?php 
        
            if(isset($_SESSION['add'])) // Check if 'add' session is set
            {
                echo $_SESSION['add']; // Display 'add' session message
                unset($_SESSION['add']); // Clear the 'add' session message
            }

            if(isset($_SESSION['upload'])) // Check if 'upload' session is set
            {
                echo $_SESSION['upload']; // Display 'upload' session message
                unset($_SESSION['upload']); // Clear the 'upload' session message
            }
        
        ?>

        <br><br>

        <!-- Dodawanie kategorii -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Tytuł: </td>
                    <td>
                        <input type="text" name="title" placeholder="Tytuł kategorii">
                    </td>
                </tr>

                <tr>
                    <td>Wybierz zdjęcie: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Wyróżnione: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Tak
                        <input type="radio" name="featured" value="No"> Nie
                    </td>
                </tr>

                <tr>
                    <td>Aktywne: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Tak
                        <input type="radio" name="active" value="No"> Nie
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Dodaj Kategorie" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Koniec -->

        <?php 
        
            //Sprawdź czy guzik jest wciśnięty
            if(isset($_POST['submit']))
            {
                //echo "Wciśnięty";

                //1. Zbierz dane z formularza
                $title = $_POST['title'];

                //Sprawdzamy czy wybrane
                if(isset($_POST['featured']))
                {
                    //Zbierz dane z formularza
                    $featured = $_POST['featured'];
                }
                else
                {
                    //Ustal domyślną 
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //Sprawdzamy czy wybrane i wybierz nazwę
                //print_r($_FILES['image']);

                //die();//Breakpoint tutaj

                if(isset($_FILES['image']['name']))
                {
                    //Wrzuć zdj 
                    //Do uploadu: Nazwa,ścieżka zasobu, ścieżka końcowa
                    $image_name = $_FILES['image']['name'];
                    
                    // Upload tylko jak wybrane
                    if($image_name != "")
                    {

                        //Autorename na zdj 
                        //Zbierz rozszerzenie pliku (jpg, png, gif, i pozostałe)
                        $ext = end(explode('.', $image_name));

                        //Rename zdj
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; 
                        

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //W końcu wrzucamy to zdj
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Sprawdzamy czy wrzuconed or not
                        //Jeśli nie, to wywalamy błąd 
                        if($upload==false)
                        {
                            //Ustaw error msg
                            $_SESSION['upload'] = "<div class='error'>Coś się zepsuło i nie wrzuciło się zdjęcie. Sprawdź neta albo kod.</div>";
                            //Redirect do strony
                            header('location:'.SITEURL.'admin/add-category.php');
                            //die.
                            die();
                        }

                    }
                }
                else
                {
                    //Nie wrzucaj i ustaw $image_name jako puste
                    $image_name="";
                }

                //2. Ustaw query aby wrzuciło do bazy
                $sql = "INSERT INTO tbl_category SET 
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //3. Wykonaj i zapisz w bazie
                $res = mysqli_query($conn, $sql);

                //4. Sprawdź.
                if($res==true)
                {
                    //Wykonane& dodane
                    $_SESSION['add'] = "<div class='success'>Kategoria dodana</div>";
                    //Redirect do strony
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Coś nie działa
                    $_SESSION['add'] = "<div class='error'>Coś się zepsuło i nie dodało kategorii</div>";
                    //Redirect
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
