<?php include('partials-front/menu.php'); ?>

<!-- Sekcja szukania jedzenia -->
<!--Nie bedziemy raczej edytować nazw klas, wątpie, że ktoś to będzie sprawdzał, a jebania  z css będzie w kurwę-->
<section class="food-search text-center">
    <div class="container">
        
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Szukaj łakoci" required> <!-- Do potencjalnej zmiany placeholdera-->
            <input type="submit" name="submit" value="Szukaj" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- End of Food Search Section -->

<?php 
    // Check if 'order' session variable is set
    if(isset($_SESSION['order']))
    {
        echo $_SESSION['order']; // Display the order information
        unset($_SESSION['order']); // Clear the 'order' session variable
    }
?>

<?php include('partials-front/footer.php'); ?>