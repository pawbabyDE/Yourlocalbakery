<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food Items</h1>

        <br /><br />

                <!-- Button do dodania  -->
                <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Dodaj jedzenie</a>

                <br /><br /><br />

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }

                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                ?>

                <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Nazwa</th>
                        <th>Cena</th>
                        <th>Zdjęcie</th>
                        <th>Wyróżnione</th>
                        <th>Aktywne</th>
                        <th>Akcje</th>
                    </tr>

                    <?php 
                        //Stwórz Query aby dostać całe jedzenie z bazy
                        $sql = "SELECT * FROM tbl_food";

                        //Wykonaj Query
                        $res = mysqli_query($conn, $sql);

                        //Policz wiersze

                        $count = mysqli_num_rows($res);

                        //Utwórz zmienna i ustaw jej wartość na 1
                        $sn=1;

                        if($count>0)
                        {
                            //Mamy w bazie
                            //Weź jedzenie z bazy i je pokaż
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //zbierz dane z pojedyńczych kolumn
                                $id = $row['id'];
                                $title = $row['title'];
                                $price = $row['price'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?>. </td>
                                    <td><?php echo $title; ?></td>
                                    <td>zł,<?php echo $price; ?></td>
                                    <td>
                                        <?php  
                                            //Sprawdź czy jest zdj
                                            if($image_name=="")
                                            {
                                                //Nie mamy zdj, pokaż błąd
                                                echo "<div class='error'>Zdjęcie nie zostało dodane.</div>";
                                            }
                                            else
                                            {
                                                //Mamy zdj, pokazujemy je
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Zaktualizuj jedzenie</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Usuń jedzenie</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //Jedzenie nie zostało dodane
                            echo "<tr> <td colspan='7' class='error'> Jedzenie nie zostało dodane </td> </tr>";
                        }

                    ?>

                    
                </table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>