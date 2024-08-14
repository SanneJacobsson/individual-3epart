<?php

require_once("Pages/layout/head.php");
require_once("Pages/layout/header.php");
require_once("Pages/layout/footer.php");

$id = $_GET['id'] ?? "";

$content = file_get_contents("http://localhost:3000/products/$id");
$product = json_decode($content);

layoutHead();

?>

<body>
    <?php
    layoutHeader();
    ?>
    <main>
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <!-- Det funakr inte att visa den specifika kategorin? -->
                <h2><?php echo $product->name; ?></h2>
                <p>Price: <?php echo $product->price; ?> SEK</p>
            </div>
        </section>
    </main>
    <!-- Footer-->
    <?php
    layoutFooter();
    ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>