const express = require("express");
const dotenv = require("dotenv");
const fs = require("fs");
const bodyParser = require("body-parser");
const path = require("path");
const app = express();
app.use(express.json());

dotenv.config();

app.use(bodyParser.json());

const dataFilePath = path.join(__dirname, "../data/products.json");
let products = JSON.parse(fs.readFileSync(dataFilePath));

const getNextId = () => {
  const ids = products.map((product) => product.id);
  return Math.max(...ids) + 1;
};

app.get("/products", (req, res) => {
  res.json(products);
});

app.get("/products/:id", (req, res) => {
  const productId = req.params.id;
  const product = products.find((p) => p.id === parseInt(productId));
  if (!product) {
    res.status(404).json({ error: "Product not found" });
  } else {
    res.json(product);
  }
});

app.post("/products", (req, res) => {
  const { name, price } = req.body;
  if (!name || typeof price !== "number") {
    return res.status(400).json({
      error: "Name and price are required and price must be a number",
    });
  }
  const newProduct = {
    id: getNextId(),
    name,
    price,
  };
  products.push(newProduct);
  fs.writeFileSync(dataFilePath, JSON.stringify(products, null, 2));
  res.status(201).json(newProduct);
});

app.put("/products/:id", (req, res) => {
  const productId = req.params.id;
  const updatedProduct = req.body;
  const index = products.findIndex((p) => p.id === parseInt(productId));
  if (index === -1) {
    res.status(404).json({ error: "Product not found" });
  } else {
    products[index] = { ...products[index], ...updatedProduct };
    fs.writeFileSync(dataFilePath, JSON.stringify(products, null, 2));
    res.json(products[index]);
  }
});

app.delete("/products/:id", (req, res) => {
  const productId = req.params.id;
  const index = products.findIndex((p) => p.id === parseInt(productId));
  if (index === -1) {
    res.status(404).json({ error: "Product not found" });
  } else {
    products.splice(index, 1);
    fs.writeFileSync(dataFilePath, JSON.stringify(products, null, 2));
    res.sendStatus(204);
  }
});

app.listen(3000, () => console.log("Server ready on port 3000."));

module.exports = app;
