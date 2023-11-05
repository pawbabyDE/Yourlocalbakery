<?php include('partials/menu.php'); ?>


        <!-- Część główna -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Zarządzaj adminami</h1>

                <br />

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //Pokazywanie wiadomości sesji
                        unset($_SESSION['add']); //Usuwanie wiadomości sesji
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }

                ?>
                <br><br><br>

                <!--Guzik dodania nowego problemu, znaczy się admina -->
                <a href="add-admin.php" class="btn-primary">Dodaj admina</a>

                <br /><br /><br />

                <table class="tbl-full">
                    <tr>
                        <th>PESEL</th>
                        <th>Imię i nazwisko</th>
                        <th>Nazwa użytkownika</th>
                        <th>Uprawnienia</th>
                    </tr>

                    
                    <?php 
                        //Query by zobaczyć adminów
                        $sql = "SELECT * FROM tbl_admin";
                        //Wykonaj query
                        $res = mysqli_query($conn, $sql);

                        //Sprawdź czy się wykonało
                        if($res==TRUE)
                        {
                            //Policz wiersze
                            $count = mysqli_num_rows($res); // Sprawdza wszystkie wiersze

                            $sn=1; //Ustaw zmienną i nadaj wartość

                            //Sprawdź ilośc wierszy
                            if($count>0)
                            {
                                //są dane w bazie
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    //Używamy while aby mieć wszystkie dane z bazy
                                    //Będzie działać tak długo jak jest cokolwiek w bazie

                                    //Zbierz pojedyńcze dane z bazy
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    //Pokaż dane z bazy
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Zmień hasło</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update admina</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">usuń admina</a>
                                        </td>
                                    </tr>

                                    <?php

                                }
                            }
                            else
                            {
                                //Nie mamy danych w bazie
                            }
                        }

                    ?>


                    
                </table>

            </div>
        </div>
        <!-- Koniec-->

<?php include('partials/footer.php'); ?>