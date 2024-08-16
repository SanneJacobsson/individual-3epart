<?php

require_once("Pages/layout/head.php");
require_once("Pages/layout/header.php");
require_once("Pages/layout/footer.php");
require_once("Pages/layout/navigation.php");

// $ch = curl_init();
// $url = "http://localhost:3000/products";
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $headers = [
//     "Content-Type: application/json"
// ];
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $response = curl_exec($ch);

// if (curl_errno($ch)) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
//     echo 'cURL Error: ' . curl_error($ch);
// } else {
//     //  header('Content-type: text/csv');

//     $data = json_decode($response, true);

//     // foreach ($data as $row) {
//     //     echo ($row['id'] . "," . $row['name'] . "," . $row['price'] . "\n");
//     // }
// }

// curl_close($ch);

$content = file_get_contents("https://individual-3epart.vercel.app/products");
$result = json_decode($content);

function expCSV()
{
    $content = file_get_contents("http://localhost:3000/products");
    $products = json_decode($content);
    $filename = 'products.csv';


    $output = fopen("php://output", 'w');

    header('Content-Type: text/csv;');
    header('Content-Disposition: attachment; filename= "' . $filename . '"');

    fputcsv($output, ['id', 'name', 'price']);
    foreach ($products as $product) {
        fputcsv($output, array($product->id, $product->name, $product->price));
    }

    fclose($output);
    exit();

}

function expXML()
{
    $content = file_get_contents("http://localhost:3000/products");
    $products = json_decode($content);
    $filename = 'products.xml';

    $xmlProducts = new SimpleXMLElement('<products/>');

    foreach ($products as $product) {
        $xmlProduct = $xmlProducts->addChild('product');
        $xmlProduct->addChild('title', $product->id);
        $xmlProduct->addChild('title', $product->name);
        $xmlProduct->addChild('price', $product->price);
    }


    header('Content-Type: text/xml;');
    header('Content-Disposition: attachment; filename= "' . $filename . '"');
    echo $xmlProducts->asXML();

    exit();

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['csv'])) {
        expCSV();
    } else if (isset($_POST['xml'])) {
        expXML();
    }
}

layoutHead();
?>

<body>
    <?php
    layoutNavigation();
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
        <form method="POST">
            <input type="hidden" value="export_csv" name="csv">
            <button type="submit">Exportera till CSV</button>
        </form>
        <form method="POST">
            <input type="hidden" value="export_xml" name="xml">
            <button type="submit">Exportera till XML</button>
        </form>
    </main>
    <?php
    layoutFooter();
    ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>