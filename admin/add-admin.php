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

    // Check if the submit button is pressed or not

    if(isset($_POST['submit']))
    {
        // Button clicked
        // echo "Button clicked";
        //that;s leftover from basic testing

        // 1. Collect data from the form using POST
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); // Encrypt passwords using MD5

        // 2. Save data to the database
        $sql = "INSERT INTO tbl_admin SET 
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        // 3. Execute the query and save the data
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // 4. Check if it passed and display data accordingly
        if($res==TRUE)
        {
            // Data inserted into the database
            // echo "Inserted";
            //also pozostałość po testach
            // Create a new session variable and display a message
            $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";
           // Redirect do panelu admina 
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Odrzuconed
            //echo "Odrzuconed";
            //also pozostałość po testach
            //Stwórz nową zmienną sesji i wyświetl wiadomość
            $_SESSION['add'] = "<div class='error'>Admin się nie dodał</div>";
            //Redirect do admina
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
?>
