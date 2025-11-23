<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$dbname = "testlogin";
$dbusername = "root";
$dbpassword = "";

// Подключение к базе
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем товары из корзины
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$total = 0;

if ($cart) {
    $ids = implode(',', array_keys($cart));
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $conn->query($sql);
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $row['quantity'] = isset($cart[$row['id']]) ? $cart[$row['id']] : 0;
            $row['subtotal'] = $row['price'] * $row['quantity'];
            $total += $row['subtotal'];
            $products[] = $row;
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Корзина - TechnoShop</title>
<style>
* {margin:0; padding:0; box-sizing:border-box;}
body {font-family: Arial, sans-serif; background-color:#fff; color:#333;}

/* Верхняя панель */
.top-bar {
    background-color:#28a745;
    color:white;
    padding:10px 20px;
    display:flex;
    justify-content:center;
    align-items:center;
    height:60px;
    position: relative;
}
.top-bar .logo {
    font-size:22px;
    font-weight:bold;
    position:absolute;
    left:50%;
    transform:translateX(-50%);
}
.top-bar .user-panel {
    font-size:18px;
    position:absolute;
    right:20px;
    display:flex;
    align-items:center;
    gap:15px;
}
.top-bar a.logout-btn {
    color:white; text-decoration:none;
    background:#218838; padding:6px 12px; border-radius:3px;
}
.top-bar a.logout-btn:hover {background:#1e7e34;}

/* Нижнее меню */
.menu-bar {
    background-color:#1e7e34;
    display:flex;
    justify-content:center;
    align-items:center;
    height:40px;
}
.menu-bar a {
    color:white;
    text-decoration:none;
    padding:10px 20px;
    font-weight:bold;
    transition:0.3s;
}
.menu-bar a:hover {
    background-color:rgba(255,255,255,0.2);
    border-radius:5px;
}

/* Контейнер корзины */
.cart-container {
    max-width:900px;
    margin:30px auto;
    background:white;
    border-radius:10px;
    padding:20px;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
}
.cart-card {
    display:flex;
    align-items:center;
    gap:20px;
    padding:15px;
    border-bottom:1px solid #ddd;
    background:#f9f9f9;
    border-radius:5px;
    margin-bottom:10px;
}
.cart-card img {
    width:100px;
    height:100px;
    object-fit:cover;
    border-radius:5px;
    cursor:pointer;
}
.cart-card div {
    flex:1;
}
.cart-card .name {
    font-weight:bold;
    font-size:18px;
    margin-bottom:5px;
    cursor:pointer;
}
.cart-card .price {
    color:#28a745;
    font-weight:bold;
    margin-bottom:5px;
}
.cart-card form {
    display:flex;
    align-items:center;
    gap:10px;
}
.cart-card input.quantity {
    width:50px;
    text-align:center;
    padding:5px;
}
.remove-btn {
    padding:5px 10px;
    background:#c0392b;
    color:white;
    text-decoration:none;
    border-radius:5px;
    font-size:14px;
}
.remove-btn:hover {background:#992d22;}

.total {
    text-align:right;
    font-size:20px;
    font-weight:bold;
    margin-top:20px;
}
.pay-btn {
    display:block;
    background:#28a745;
    color:white;
    text-decoration:none;
    text-align:center;
    padding:12px;
    border-radius:5px;
    font-weight:bold;
    margin-top:20px;
}
.pay-btn:hover {background:#218838;}
</style>
</head>
<body>

<!-- Верхняя панель -->
<div class="top-bar">
    <div class="logo">TechnoShop</div>
    <div class="user-panel">
        <?php echo htmlspecialchars($_SESSION['username']); ?>
        <a href="logout.php" class="logout-btn">Выйти</a>
    </div>
</div>

<!-- Нижнее меню -->
<div class="menu-bar">
    <a href="welcome.php">Главная</a>
    <a href="categories.php">Категории</a>
    <a href="cart.php">Корзина</a>
</div>

<!-- Контент корзины -->
<div class="cart-container">
    <h2>Ваша корзина</h2>
    <?php if ($products): ?>
        <?php foreach($products as $p): ?>
            <div class="cart-card">
                <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" onclick="window.location='product.php?id=<?php echo $p['id']; ?>'">
                <div>
                    <div class="name" onclick="window.location='product.php?id=<?php echo $p['id']; ?>'"><?php echo htmlspecialchars($p['name']); ?></div>
                    <div class="price"><?php echo $p['price']; ?> тг</div>
                </div>
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                    <input type="hidden" name="action" value="update">
                    <input type="number" class="quantity" name="quantity" value="<?php echo $p['quantity']; ?>" min="1" onchange="this.form.submit();">
                    <a href="add_to_cart.php?id=<?php echo $p['id']; ?>&action=remove" class="remove-btn">Удалить</a>
                </form>
            </div>
        <?php endforeach; ?>
        <div class="total">Общая сумма: <?php echo $total; ?> тг</div>
        <a href="#" class="pay-btn">Оплатить</a>
    <?php else: ?>
        <p>Ваша корзина пуста.</p>
    <?php endif; ?>
</div>


</body>
</html>
