<?php
class Product {
    private $id;
    private $name;
    private $price;
    private $quantity;

    public function __construct($id, $name, $price, $quantity) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    // Getters and setters for product properties
}

class Inventory {
    private $products = [];

    public function addProduct($product) {
        $this->products[] = $product;
    }

    public function getProductById($id) {
        foreach ($this->products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null; // Product not found
    }

    public function updateProductQuantity($id, $quantity) {
        $product = $this->getProductById($id);
        if ($product) {
            $product->setQuantity($quantity);
        }
    }

    public function listProducts() {
        return $this->products;
    }
}

$inventory = new Inventory();
$inventory->addProduct(new Product(1, "Laptop", 800, 10));
$inventory->addProduct(new Product(2, "Phone", 400, 20));

// Usage example:
$productId = 1;
$quantityToOrder = 5;
$inventory->updateProductQuantity($productId, 5);

// List products
$products = $inventory->listProducts();
foreach ($products as $product) {
    echo "Product: " . $product->getName() . ", Quantity: " . $product->getQuantity() . "<br>";
}
