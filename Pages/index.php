<?php

require_once("Pages/layout/head.php");
require_once("Pages/layout/header.php");
require_once("Pages/layout/footer.php");

$ch = curl_init();
$url = "http://localhost:3000/products";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$headers = [
    "Content-Type: application/json"
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo 'cURL Error: ' . curl_error($ch);
} else {
    //  header('Content-type: text/csv');

    $data = json_decode($response, true);

    // foreach ($data as $row) {
    //     echo ($row['id'] . "," . $row['name'] . "," . $row['price'] . "\n");
    // }
}

curl_close($ch);

$content = file_get_contents("http://localhost:3000/products");
$result = json_decode($content);

layoutHead();
?>

<body>
    <?php
    layoutHeader();
    ?>
    <main>
        <table class="table">

            <?php
            foreach ($result as $product) {
                echo "<tr><td>$product->id</td><td>$product->name</td><td>$product->price SEK</td><td><a href='/viewproduct?id=$product->id'>Show More</a></td></tr>";
            }
            ?>

        </table>
    </main>
    <?php
    layoutFooter();
    ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>