<?php
class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $image;

    public function __construct($id, $name, $price, $description, $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage()
    {
        return $this->image;
    }
}

class ProductCatalog
{
    private $products = [];

    public function addProduct($product)
    {
        $this->products[] = $product;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function getProductById($id)
    {
        foreach ($this->products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null; // Product not found
    }
}

class User
{
    private $id;
    private $username;
    private $email;
    private $password;

    public function __construct($id, $username, $email, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function verifyPassword($inputPassword)
    {
        return $this->password === $inputPassword;
    }
}

class UserManager
{
    private $users = [];

    public function addUser($user)
    {
        $this->users[] = $user;
    }

    public function getUserByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        return null; // User not found
    }
}

// Initialize product catalog
$productCatalog = new ProductCatalog();
$productCatalog->addProduct(new Product(1, "Laptop", 800, "High-performance laptop with the latest CPU.", "laptop.jpeg"));
$productCatalog->addProduct(new Product(2, "Phone", 400, "Smartphone with advanced features.", "phone.jpeg"));

// Initialize user manager
$userManager = new UserManager();
$userManager->addUser(new User(1, "john_doe", "john@example.com", "password1"));

// Handle user login
$loginError = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user = $userManager->getUserByUsername($username);

    if ($user && $user->verifyPassword($password)) {
        // Successful login
        session_start();
        $_SESSION["user"] = $user;
    } else {
        $loginError = 'Invalid username or password.';
    }
}

// Handle user logout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    session_start();
    unset($_SESSION["user"]);
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>E-commerce Store</title>
</head>

<body>
    <h1>Product Catalog</h1>
    <?php foreach ($productCatalog->getProducts() as $product) { ?>
        <div class="product">
            <img src="<?php echo $product->getImage(); ?>" alt="<?php echo $product->getName(); ?>">
            <h2><?php echo $product->getName(); ?></h2>
            <p><?php echo $product->getDescription(); ?></p>
            <p>$<?php echo $product->getPrice(); ?></p>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                <input type="number" name="quantity" value="1" min="1">
                <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
        </div>
    <?php } ?>
    <?php if (isset($_SESSION["user"])) { ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="submit" name="logout" value="Logout">
        </form>
    <?php } else { ?>
        <h2>Login</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <span style="color: red;"><?php echo $loginError; ?></span><br>
            <input type="submit" name="login" value="Login">
        </form>
    <?php } ?>
</body>

</html>