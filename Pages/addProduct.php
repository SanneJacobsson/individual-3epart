<?php

require_once("Pages/layout/head.php");
require_once("Pages/layout/header.php");
require_once("Pages/layout/footer.php");
require_once("Pages/layout/navigation.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {

    $price = $_POST['price'];
    $name = $_POST['name'];

    $url = "http://localhost:3000/products";

    $data = [
        'name' => $name,
        'price' => (float) $price
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        echo 'Response:' . $response;
    }

    curl_close($ch);
    // header("Location: /");
    // exit();
}

layoutHead();
?>

<body>
    <?php
    layoutNavigation();
    ?>
    <main>
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <form method="post">
                    <h5>Add Movie</h5>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name"><br><br>
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price"><br><br>
                    <input type="submit" name="add" value="Submit">
                </form>
            </div>
        </section>
    </main>
    <?php
    layoutFooter();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>