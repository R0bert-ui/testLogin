<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$dbname = "testlogin";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($servername,$dbusername,$dbpassword,$dbname);
if($conn->connect_error) die("Ошибка подключения: ".$conn->connect_error);

// Получаем id категории
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($category_id<=0){
    header("Location: categories.php");
    exit();
}

// Получаем категорию
$catResult = $conn->query("SELECT * FROM categories WHERE id=$category_id");
if(!$catResult || $catResult->num_rows==0){
    echo "Категория не найдена.";
    exit();
}
$category = $catResult->fetch_assoc();

// Сортировка
$sort = (isset($_GET['sort']) && $_GET['sort']=='desc') ? 'DESC' : 'ASC';

// Получаем товары категории
$prodResult = $conn->query("SELECT * FROM products WHERE category_id=$category_id ORDER BY price $sort");

$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($category['name']) ?> - TechnoShop</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;padding:0;}
.top-bar,.menu-bar{display:flex;align-items:center;justify-content:center;color:white;}
.top-bar{background:#28a745;height:60px;position:relative;padding:0 20px;}
.top-bar .logo{position:absolute;left:50%;transform:translateX(-50%);font-weight:bold;font-size:22px;}
.top-bar .user-panel{position:absolute;right:20px;display:flex;align-items:center;gap:15px;}
.top-bar a.logout-btn{background:#218838;padding:6px 12px;border-radius:3px;text-decoration:none;color:white;}
.top-bar a.logout-btn:hover{background:#1e7e34;}
.menu-bar{background:#1e7e34;height:40px;}
.menu-bar a{color:white;text-decoration:none;padding:10px 20px;font-weight:bold;transition:0.3s;}
.menu-bar a:hover{background:rgba(255,255,255,0.2);border-radius:5px;}
.category-container{max-width:1000px;margin:30px auto;padding:0 10px;}
.sort-buttons{margin-bottom:20px;display:flex;gap:10px;}
.sort-buttons a{text-decoration:none;padding:6px 12px;background:#28a745;color:white;border-radius:4px;font-weight:bold;transition:0.3s;}
.sort-buttons a:hover{background:#1e7e34;}
.products-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px;}
.product-card{background:white;border-radius:10px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.1);display:flex;flex-direction:column;justify-content:space-between;transition: transform 0.2s;}
.product-card:hover{transform:translateY(-5px);}
.product-card img{width:100%;height:180px;object-fit:cover;cursor:pointer;}
.product-info{padding:10px;flex:1;}
.product-info h3{font-size:18px;color:#28a745;cursor:pointer;margin-bottom:5px;}
.product-info p{font-size:16px;color:#1e7e34;font-weight:bold;margin-bottom:10px;}
.add-cart-btn{background:#28a745;color:white;border:none;padding:10px;width:100%;font-weight:bold;cursor:pointer;transition:0.3s;border-radius:0 0 10px 10px;}
.add-cart-btn:hover{background:#1e7e34;}
</style>
</head>
<body>

<div class="top-bar">
    <div class="logo">TechnoShop</div>
    <div class="user-panel">
        <?= htmlspecialchars($_SESSION['username']) ?>
        <a href="logout.php" class="logout-btn">Выйти</a>
    </div>
</div>

<div class="menu-bar">
    <a href="welcome.php">Главная</a>
    <a href="categories.php">Категории</a>
    <a href="cart.php">Корзина</a>
</div>

<div class="category-container">
    <h2 style="margin-bottom:20px;"><?= htmlspecialchars($category['name']) ?></h2>

    <div class="sort-buttons">
        <a href="category.php?id=<?= $category_id ?>&sort=asc">Цена ↑</a>
        <a href="category.php?id=<?= $category_id ?>&sort=desc">Цена ↓</a>
    </div>

    <div class="products-grid">
        <?php if($prodResult && $prodResult->num_rows>0): ?>
            <?php while($row = $prodResult->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($row['image']) ?>" onclick="location.href='product.php?id=<?= $row['id'] ?>'">
                    <div class="product-info">
                        <h3 onclick="location.href='product.php?id=<?= $row['id'] ?>'"><?= htmlspecialchars($row['name']) ?></h3>
                        <p><?= $row['price'] ?> тг</p>
                    </div>
                    <form method="post" action="add_to_cart.php">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="add-cart-btn">Добавить в корзину</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Товары отсутствуют.</p>
        <?php endif; ?>
    </div>
</div>


</body>
</html>
