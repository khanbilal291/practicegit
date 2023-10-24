<?php
class User {
    private $id;
    private $username;
    private $email;
    private $orders = [];

    public function __construct($id, $username, $email) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    public function placeOrder($cart) {
        $order = new Order($cart, $this);
        $this->orders[] = $order;
        return $order;
    }

    public function getOrders() {
        return $this->orders;
    }
}

class Product {
    private $id;
    private $name;
    private $price;

    public function __construct($id, $name, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    // Getters for product properties
}

class Cart {
    private $items = [];

    public function addItem($product, $quantity) {
        $this->items[] = ['product' => $product, 'quantity' => $quantity];
    }

    public function getItems() {
        return $this->items;
    }

    public function calculateTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}

class Order {
    private $id;
    private $user;
    private $cart;
    private $totalPrice;
    private $status;

    public function __construct($cart, $user) {
        $this->id = uniqid();
        $this->cart = $cart;
        $this->user = $user;
        $this->totalPrice = $cart->calculateTotal();
        $this->status = 'Pending';
    }

    public function processPayment($paymentInfo) {
        // Process the payment
        $this->status = 'Paid';
    }

    public function getStatus() {
        return $this->status;
    }
}

// Usage
$user = new User(1, "john_doe", "john@example.com");
$product1 = new Product(101, "Laptop", 800);
$product2 = new Product(102, "Phone", 400);

$cart = new Cart();
$cart->addItem($product1, 2);
$cart->addItem($product2, 1);

$order = $user->placeOrder($cart);
$order->processPayment("Credit Card");

echo "Order Status: " . $order->getStatus();

?>