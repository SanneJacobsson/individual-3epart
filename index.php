<?php
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

    foreach ($data as $row) {
        echo ($row['id'] . "," . $row['name'] . "," . $row['price'] . "\n");
    }
}

curl_close($ch);

$content = file_get_contents("http://localhost:3000/products");
$result = json_decode($content);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Movies</title>
</head>

<body>
    <main>
        <table>

            <?php
            foreach ($result as $row) {
                echo "<tr><td>$row->id</td><td>$row->name</td><td>$row->price SEK</td></tr>";
            }
            ?>

        </table>
    </main>
</body>