<?php

require_once("Pages/layout/head.php");
require_once("Pages/layout/header.php");
require_once("Pages/layout/footer.php");
require_once("Pages/layout/navigation.php");

$id = $_GET['id'] ?? "";

$content = file_get_contents("http://localhost:3000/products/$id");
$product = json_decode($content);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {

        $url = "http://localhost:3000/products/$id";

        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price']
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            exit();
        }

        curl_close($ch);
        $content = file_get_contents("http://localhost:3000/products/$id");
        $product = json_decode($content);
    } else if (isset($_POST['delete'])) {

        $url = "http://localhost:3000/products/$id";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            exit();
        }

        curl_close($ch);

        header("Location: /");
        exit();

    }
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
                <h2><?php echo htmlspecialchars($product->name); ?></h2>
                <p>Price: <?php echo htmlspecialchars($product->price); ?> SEK</p>
                <form method="post">
                    <h5>Update Product</h5>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name"
                        value="<?php echo htmlspecialchars($product->name); ?>"><br><br>
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price"
                        value="<?php echo htmlspecialchars($product->price); ?>"><br><br>
                    <input type="submit" name="update" value="Submit">
                </form>
                <form method="post" style="margin-top: 20px;">
                    <input type="hidden" name="delete" value="true">
                    <input type="submit" value="Delete Product" style="background-color: red; color: white;">
                </form>
            </div>
        </section>
    </main>
    <?php
    layoutFooter();
    ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>