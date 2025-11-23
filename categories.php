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

// Получаем список категорий
$catResult = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Категории - TechnoShop</title>
<style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:Arial,sans-serif;background:#fff;color:#333;min-height:100vh;display:flex;flex-direction:column;}

    /* Верхняя полоса */
    .top-bar{background:#28a745;color:white;padding:10px 20px;display:flex;justify-content:center;align-items:center;height:60px;position:relative;}
    .top-bar .logo{position:absolute;left:50%;transform:translateX(-50%);font-weight:bold;font-size:22px;}
    .top-bar .user-panel{position:absolute;right:20px;display:flex;align-items:center;gap:15px;}
    .top-bar a.logout-btn{background:#218838;padding:6px 12px;border-radius:3px;text-decoration:none;color:white;}
    .top-bar a.logout-btn:hover{background:#1e7e34;}

    /* Меню */
    .menu-bar{background:#1e7e34;display:flex;justify-content:center;align-items:center;height:40px;}
    .menu-bar a{color:white;text-decoration:none;padding:10px 20px;font-weight:bold;transition:0.3s;}
    .menu-bar a:hover{background:rgba(255,255,255,0.2);border-radius:5px;}

    /* Контейнер категорий */
    .categories-container{max-width:900px;margin:30px auto;display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px;padding:0 10px;flex:1;}

    .category-card{background:#f5f5f5;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.1);padding:10px;text-align:center;cursor:pointer;transition: transform 0.2s, background 0.3s;}
    .category-card:hover{transform: translateY(-5px);background:#e0f2e9;}
    .category-card h3{color:#28a745;font-size:20px;margin-bottom:10px;}
    .category-card img{max-width:100%;border-radius:6px;object-fit:cover;height:150px;}
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

<div class="categories-container">
    <?php if($catResult && $catResult->num_rows>0): ?>
        <?php while($cat = $catResult->fetch_assoc()): ?>
            <div class="category-card" onclick="location.href='category.php?id=<?= $cat['id'] ?>'">
                <h3><?= htmlspecialchars($cat['name']) ?></h3>
                <?php
                // Проверяем, есть ли ID товара для изображения категории
                if(!empty($cat['image_product_id'])) {
                    $prod_id = intval($cat['image_product_id']);
                    $imgResult = $conn->query("SELECT image FROM products WHERE id=$prod_id");
                    if($imgResult && $imgResult->num_rows>0){
                        $imgRow = $imgResult->fetch_assoc();
                        echo '<img src="'.htmlspecialchars($imgRow['image']).'" alt="Категория">';
                    }
                }
                ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Категории отсутствуют.</p>
    <?php endif; ?>
</div>

</body>
</html>
