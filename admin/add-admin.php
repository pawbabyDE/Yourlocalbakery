<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add'])) //Sesja ustawiona?
            {
                echo $_SESSION['add']; //Pokaż wiadomość sesji
                unset($_SESSION['add']); //Usuń wiadomość sesji
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Imię i nazwisko: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="No wpisuj">
                    </td>
                </tr>

                <tr>
                    <td>Nazwa użytkownika: </td>
                    <td>
                        <input type="text" name="username" placeholder="Twoja nazwa użytkownika">
                    </td>
                </tr>

                <tr>
                    <td>Hasło: </td>
                    <td>
                        <input type="password" name="password" placeholder="Twoje hasło">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php 
    //Przetwórz dane i zapisz w bazie

    //Zobacz czy guzik jest wciśnięty or not

    if(isset($_POST['submit']))
    {
        // Kliknięty
        //echo "Wciśnięty guzik";

        //1. Zbierz dane z formularza POSTem
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Enkrypcja haseł z użyciem MD5

        //2. Zapisanie danych w bazie 
        $sql = "INSERT INTO tbl_admin SET 
            full_name='$full_name',
            username='$username',
            password='$password'
        ";
 
        //3. Wykonanie zapytania i zapisanie danych
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Zobacz czy przeszło i wyświetl dane odpowiednio
        if($res==TRUE)
        {
            //Dane wsadzone do bazy
            //echo "Wsadzoned";
            //Stwórz nową zmienną sesji i wyświetl wiadomość
            $_SESSION['add'] = "<div class='success'>Dodano admina</div>";
            //Redirect do panelu admina 
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Odrzuconed
            //echo "Odrzuconed";
            //Stwórz nową zmienną sesji i wyświetl wiadomość
            $_SESSION['add'] = "<div class='error'>Admin się nie dodał</div>";
            //Redirect do admina
            header("location:".SITEURL.'admin/add-admin.php');
        }

    }
    
?>