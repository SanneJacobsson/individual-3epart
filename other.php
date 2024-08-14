<?php
$content = file_get_contents("http://localhost:3000/products");
$result = json_decode($content);
?>



<body>
    <main>

        <tbody>
            <?php
            foreach ($result["data"] as $product) {
                echo "<tr><td>$product->id</td><td>$product->name</td><td>$product->price SEK</td></tr>";
            }
            ?>
        </tbody>
    </main>
</body>