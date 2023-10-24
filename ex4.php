<?php
class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $orders = [];

    public function __construct($id, $username, $email, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function placeOrder($cart)
    {
        $order = new Order($this, $cart);
        $this->orders[] = $order;
        return $order;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }
}

class Product
{
    private $id;
    private $name;
    private $price;

    public function __construct($id, $name, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    // Getters for product properties
}

class Cart
{
    private $items = [];

    public function addItem($product, $quantity)
    {
        $this->items[] = ['product' => $product, 'quantity' => $quantity];
    }

    public function getItems()
    {
        return $this->items;
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}

class Order
{
    private $id;
    private $user;
    private $cart;
    private $totalPrice;
    private $status;
    private $timestamp;

    public function __construct($user, $cart)
    {
        $this->id = uniqid();
        $this->user = $user;
        $this->cart = $cart;
        $this->totalPrice = $cart->calculateTotal();
        $this->status = 'Pending';
        $this->timestamp = date('Y-m-d H:i:s');
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
}

class ProductCatalog
{
    private $products = [];

    public function addProduct($product)
    {
        $this->products[] = $product;
    }

    public function getProductById($id)
    {
        foreach ($this->products as $product) {
            if ($product->id === $id) {
                return $product;
            }
        }
        return null; // Product not found
    }
}

class UserAccountManager
{
    private $users = [];

    public function addUser($user)
    {
        $this->users[] = $user;
    }

    public function findUserByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        return null; // User not found
    }
}

// Usage
$productCatalog = new ProductCatalog();

$product1 = new Product(1, "Laptop", 800);
$product2 = new Product(2, "Phone", 400);

$productCatalog->addProduct($product1);
$productCatalog->addProduct($product2);

$userAccountManager = new UserAccountManager();

$user1 = new User(1, "john_doe", "john@example.com", "password1");
$user2 = new User(2, "jane_smith", "jane@example.com", "password2");

$userAccountManager->addUser($user1);
$userAccountManager->addUser($user2);

$user = $userAccountManager->findUserByUsername("john_doe");
$cart = new Cart();
$cart->addItem($productCatalog->getProductById(1), 2);

$order = $user->placeOrder($cart);
$order->setStatus("Paid");

echo "Order Status: " . $order->getStatus();
echo "Order Timestamp: " . $order->getTimestamp();
