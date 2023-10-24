<?php
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

$productCatalog = new ProductCatalog();
$productCatalog->addProduct(new Product(1, "Laptop", 800));
$productCatalog->addProduct(new Product(2, "Phone", 400));

$cart = new Cart();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_to_cart"])) {
        $product_id = $_POST["product_id"];
        $quantity = $_POST["quantity"];
        $product = $productCatalog->getProductById($product_id);
        $cart->addItem($product, $quantity);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>E-commerce Store</title>
</head>
<body>
    <h1>Product Catalog</h1>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($productCatalog->getProducts() as $product) { ?>
            <tr>
                <td><?php echo $product->getName(); ?></td>
                <td>$<?php echo $product->getPrice(); ?></td>
                <td>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <input type="submit" name="add_to_cart" value="Add to Cart">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <h2>Shopping Cart</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php foreach ($cart->getItems() as $item) { ?>
            <tr>
                <td><?php echo $item['product']->getName(); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo $item['product']->getPrice() * $item['quantity']; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td>Total:</td>
            <td></td>
            <td>$<?php echo $cart->calculateTotal(); ?></td>
        </tr>
    </table>
    <h2>Shopping Cart</h2>
<table>
    <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    <?php foreach ($cart->getItems() as $item) { ?>
        <tr>
            <?php if ($item['product']) { ?>
                <td><?php echo $item['product']->getName(); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo $item['product']->getPrice() * $item['quantity']; ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
    <tr>
        <td>Total:</td>
        <td></td>
        <td>$<?php echo $cart->calculateTotal(); ?></td>
    </tr>
</table>

</body>
</html>
