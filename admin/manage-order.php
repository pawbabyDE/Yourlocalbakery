<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Zarządzanie zamówieniami jedzenia.</h1>

                <br /><br /><br />

                <?php 
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>
                <br><br>

                <table class="tbl-full">
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Data zamówienia</th>
                        <th width="10%">jedzenie</th>
                        <th width="5%">Cena</th>
                        <th width="5%">Ilość</th>
                        <th width="6%">Kwota całkowita</th>
                        <th width="8%">Status</th>
                        <th width="10%">Klient</th>
                        <th width="10%">Numer tel</th>
                        <th width="15%">Email</th>
                        <th width="10%">Adres</th>
                        <th>Akcje</th>
                    </tr>

                    <?php 
                        //Zbierz wszystkie zamówienia z bazy
                        $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; // Pokaż najnowsze zamówienia najpierw
                        //Wykonaj Query
                        $res = mysqli_query($conn, $sql);
                        //Policz wiersze
                        $count = mysqli_num_rows($res);

                        $sn = 1; //Utwórz zmienna i ustaw jej wartość na 1

                        if($count>0)
                        {
                            //Zamówienie dostępne
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Zdobądź szczegóły zamówienia
                                $id = $row['id'];
                                $food = $row['food'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $row['total'];
                                $order_date = $row['order_date'];
                                $status = $row['status'];
                                $customer_name = $row['customer_name'];
                                $customer_contact = $row['customer_contact'];
                                $customer_email = $row['customer_email'];
                                $customer_address = $row['customer_address'];
                                
                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?> </td>
                                        <td><?php echo $order_date; ?></td>
                                        <td><?php echo $food; ?></td>
                                        <td><?php echo 'zł'.$price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo 'zł'.$total; ?></td>
                                        

                                        <td>
                                            <?php 
                                                // Zamówione, W trakcie dostawy, Dostarczone, Anulowane

                                                if($status=="Ordered")
                                                {
                                                    echo "<label style='color: blue;'>$status</label>";
                                                }
                                                elseif($status=="On Delivery")
                                                {
                                                    echo "<label style='color: orange;'>$status</label>";
                                                }
                                                elseif($status=="Delivered")
                                                {
                                                    echo "<label style='color: green;'><b>$status</b></label>";
                                                }
                                                elseif($status=="Cancelled")
                                                {
                                                    echo "<label style='color: red;'>$status</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $customer_name; ?></td>
                                        <td><?php echo $customer_contact; ?></td>
                                        <td><?php echo $customer_email; ?></td>
                                        <td><?php echo $customer_address; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Zaktualizuj zamówienie</a>
                                        </td>
                                    </tr>

                                <?php

                            }
                        }
                        else
                        {
                            //Zamówienie nie jest dostępne
                            echo "<tr><td colspan='12' class='error'>Zamówienia nie są dostępne.</td></tr>";
                        }
                    ?>

 
                </table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>