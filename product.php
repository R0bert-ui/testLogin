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

// Получаем id товара из GET
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    echo "Товар не найден.";
    exit();
}

// Запрос товара
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id=c.id 
        WHERE p.id=$product_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "Товар не найден.";
    exit();
}

$product = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($product['name']); ?> - TechnoShop</title>
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

/* Контейнер товара */
.product-container {
    max-width:900px;
    margin:30px auto;
    background:white;
    border-radius:10px;
    padding:20px;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
    display:flex;
    flex-wrap:wrap;
    gap:20px;
}

.product-image {
    flex:1 1 300px;
}
.product-image img {
    width:100%;
    border-radius:10px;
    cursor:pointer;
}

.product-details {
    flex:2 1 400px;
    display:flex;
    flex-direction:column;
    justify-content:flex-start;
    gap:15px;
}
.product-details h2 {font-size:28px; color:#28a745; cursor:pointer;}
.product-details p.price {font-size:22px; color:#28a745; font-weight:bold;}
.product-details p.category {font-size:16px; color:#555;}
.product-details p.description {font-size:16px; color:#333; line-height:1.5;}

.btn {
    display:inline-block;
    text-decoration:none;
    padding:10px 20px;
    border-radius:5px;
    color:white;
    font-weight:bold;
    transition:0.3s;
    cursor:pointer;
    text-align:center;
}
.back-btn {background:#1e7e34;}
.back-btn:hover {background:#145214;}
.add-cart-btn {background:#28a745;}
.add-cart-btn:hover {background:#218838;}
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

<!-- Контент товара -->
<div class="product-container">
    <div class="product-image">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="product-details">
        <h2 onclick="window.location='product.php?id=<?php echo $product['id']; ?>'"><?php echo htmlspecialchars($product['name']); ?></h2>
        <p class="price"><?php echo $product['price']; ?> тг</p>
        <p class="category">Категория: <?php echo htmlspecialchars($product['category_name']); ?></p>
        <p class="description"><?php echo nl2br(htmlspecialchars(isset($product['description']) ? $product['description'] : 'Описание отсутствует')); ?></p>
        
        <form method="post" action="add_to_cart.php" style="display:flex; gap:10px;">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="btn add-cart-btn">Добавить в корзину</button>
        </form>

        <a href="welcome.php" class="btn back-btn">Назад к списку товаров</a>
    </div>
</div>


</body>
</html>
