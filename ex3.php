<?php
class User {
    private $id;
    private $username;
    private $email;
    private $cart;

    public function __construct($id, $username, $email) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->cart = new Cart();
    }

    public function addToCart($product, $quantity) {
        $this->cart->addItem($product, $quantity);
    }

    public function checkout() {
        $order = new Order($this, $this->cart);
        $payment = new Payment($order);
        $payment->processPayment();
        return $order;
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

    public function getPrice() {
        return $this->price;
    }
}

class Cart {
    private $items = [];

    public function addItem($product, $quantity) {
        $this->items[] = ['product' => $product, 'quantity' => $quantity];
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
    private $user;
    private $cart;
    private $totalPrice;
    private $status;

    public function __construct($user, $cart) {
        $this->user = $user;
        $this->cart = $cart;
        $this->totalPrice = $cart->calculateTotal();
        $this->status = 'Pending';
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }
}

class Payment {
    private $order;
    private $status;

    public function __construct($order) {
        $this->order = $order;
    }

    public function processPayment() {
        // Simulate payment processing
        $this->status = 'Paid';
        $this->order->setStatus('Paid');
    }

    public function getStatus() {
        return $this->status;
    }
}

// Usage
$user = new User(1, "john_doe", "john@example.com");
$product1 = new Product(101, "Laptop", 800);
$product2 = new Product(102, "Phone", 400);

$user->addToCart($product1, 2);
$user->addToCart($product2, 1);

$order = $user->checkout();
echo "Order Status: " . $order->getStatus();
// echo "Payment Status: " . $order->getPaymentStatus();
?>