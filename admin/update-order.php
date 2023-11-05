<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Zaktualizuj zamówienie</h1>
        <br><br>

        <?php 
            // Sprawdź czy ID jest ustawione
            if(isset($_GET['id'])) {
                // Znajdź to ID
                $id = $_GET['id'];

                // Znajdź detale bazując na ID
                // Stwórz query do tego
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                // Wykonaj Query
                $res = mysqli_query($conn, $sql);
                // Policz wiersze
                $count = mysqli_num_rows($res);

                if ($count == 1) {
                    // Detale dostępne
                    $row = mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                } else {
                    // Detale nie dostępne
                    // Redirect
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            } else {
                // Redirect
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        ?>

        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Nazwa </td>
                    <td><b> <?php echo htmlspecialchars($food); ?> </b></td>
                </tr>

                <tr>
                    <td>Cena</td>
                    <td>
                        <b> PLN <?php echo $price; ?></b>
                    </td>
                </tr>

                <tr>
                    <td>Ilość</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if ($status == "Ordered") {echo "selected";} ?> value="Zamówiono">Zamówione</option>
                            <option <?php if ($status == "On Delivery") {echo "selected";} ?> value="W Dostawie">W dostawie</option>
                            <option <?php if ($status == "Delivered") {echo "selected";} ?> value="Dostarczono">Dostarczone</option>
                            <option <?php if ($status == "Cancelled") {echo "selected";} ?> value="Anulowano">Anulowane</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Imie klienta: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>">
                    </td>
                </tr>

                <tr>
                    <td>Kontakt: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo htmlspecialchars($customer_contact); ?>">
                    </td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo htmlspecialchars($customer_email); ?>">
                    </td>
                </tr>

                <tr>
                    <td>Adres: </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo htmlspecialchars($customer_address); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td clospan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        
        </form>

        <?php 
            // Sprawdź czy guzik jest wciśnięty
            if (isset($_POST['submit'])) {
                // Zbierz dane z formularza
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $total = $price * $qty;
                $status = $_POST['status'];
                $customer_name = htmlspecialchars($_POST['customer_name']);
                $customer_contact = htmlspecialchars($_POST['customer_contact']);
                $customer_email = htmlspecialchars($_POST['customer_email']);
                $customer_address = htmlspecialchars($_POST['customer_address']);

                // Zaktualizuj
                $sql2 = "UPDATE tbl_order SET 
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id=$id
                ";

                // Wykonaj
                $res2 = mysqli_query($conn, $sql2);

                // Sprawdź czy się wykonało
                // Redirect z wiadomością
                if ($res2 == true) {
                    // Updated
                    $_SESSION['update'] = "<div class='success'>Zamówienie zaktualizowane prawidłowo.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                } else {
                    // Nie udało się
                    $_SESSION['update'] = "<div class='error'>Nie udało sie zaktualizować zamówienia</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
