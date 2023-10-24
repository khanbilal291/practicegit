<?php
session_start();

class Product {
    private $id;
    private $name;
    private $price;

    public function __construct($id, $name, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
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
}

class ProductCatalog {
    private $products = [];

    public function addProduct($product) {
        $this->products[] = $product;
    }

    public function getProducts() {
        return $this->products;
    }

    public function getProductById($id) {
        foreach ($this->products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null; // Product not found
    }
}

class User {
    private $id;
    private $username;
    private $password;

    public function __construct($id, $username, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername() {
        return $this->username;
    }

    public function verifyPassword($inputPassword) {
        return password_verify($inputPassword, $this->password);
    }
}

class UserManager {
    private $users = [];

    public function addUser($user) {
        $this->users[] = $user;
    }

    public function getUserByUsername($username) {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        return null; // User not found
    }
}

$productCatalog = new ProductCatalog();
$productCatalog->addProduct(new Product(1, "Laptop", 800));
$productCatalog->addProduct(new Product(2, "Phone", 400));

$userManager = new UserManager();
$userManager->addUser(new User(1, "john_doe", password_hash("password1", PASSWORD_DEFAULT)));

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user = $userManager->getUserByUsername($username);

    if ($user && $user->verifyPassword($password)) {
        $_SESSION["user"] = $user;
    } else {
        $loginError = 'Invalid username or password.';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    unset($_SESSION["user"]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>E-commerce Store</title>
    <style>
        .product {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 200px;
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>E-commerce Store</h1>

    <?php if (isset($_SESSION["user"])) { ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="submit" name="logout" value="Logout">
        </form>
        <h2>Welcome, <?php echo $_SESSION["user"]->getUsername(); ?></h2>
    <?php } else { ?>
        <h2>Login</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <span style="color: red;"><?php echo $loginError; ?></span><br>
            <input type="submit" name="login" value="Login">
        </form>
    <?php } ?>

    <h2>Product Catalog</h2>
    <?php foreach ($productCatalog->getProducts() as $product) { ?>
        <div class="product">
            <h3><?php echo $product->getName(); ?></h3>
            <p>$<?php echo $product->getPrice(); ?></p>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                <input type="number" name="quantity" value="1" min="1">
                <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
        </div>
    <?php } ?>
</body>
</html>
