<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Подключение к базе данных
$servername = "localhost";
$dbname = "testlogin";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем товары
$sql = "SELECT * FROM products"; // таблица products с полями id, name, price, image
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>TechnoShop</title>
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: Arial, sans-serif; background-color:#f5f5f5; }

    header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        background-color:#28a745;
        padding:5px 20px;
        color:white;
        width:100%;
        height: 70px;
    }
    .logo { font-size:20px; font-weight:bold; }
    .user-panel { display:flex; align-items:center; gap:10px; }
    .username { font-size:16px; }
    .logout-btn {
        background-color:#218838; color:white; padding:5px 10px;
        border-radius:3px; text-decoration:none; font-size:14px;
    }
    .logout-btn:hover { background-color:#1e7e34; }

    .slider-container { max-width:1000px; margin:30px auto; border-radius:10px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.2);}
    .slider { position:relative; width:100%; overflow:hidden; }
    .slides { display:flex; transition: transform 0.5s ease-in-out; }
    .slides img { width:100%; flex-shrink:0; display:block; }
    .slider-btn { position:absolute; top:50%; transform:translateY(-50%); background-color:rgba(0,0,0,0.5); color:white; border:none; padding:10px; cursor:pointer; border-radius:3px; font-size:18px;}
    .prev { left:10px; }
    .next { right:10px; }

    /* Заголовок "Популярные товары" */
    .popular-title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin: 40px 0 20px 0;
        color: #333;
    }

    /* Карточки товаров */
    .products-container {
        max-width:1200px;
        margin: 0 auto 40px auto;
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        padding: 0 10px;
    }

    .product-card {
        background:white;
        border-radius:10px;
        overflow:hidden;
        box-shadow:0 4px 10px rgba(0,0,0,0.1);
        text-align:center;
        transition: transform 0.2s;
    }
    .product-card:hover { transform: translateY(-5px); }
    .product-card img { width:100%; height:180px; object-fit:cover; }
    .product-card h3 { padding:10px; font-size:18px; color:#333; }
    .product-card p { padding-bottom:10px; font-size:16px; color:#28a745; font-weight:bold; }
</style>
</head>
<body>

<header>
    <div class="logo">TechnoShop</div>
    <div class="user-panel">
        <div class="username"><?= htmlspecialchars($_SESSION['username']) ?></div>
        <a href="logout.php" class="logout-btn">Выйти</a>
    </div>
</header>

<div class="slider-container">
    <div class="slider">
        <div class="slides">
            <img src="https://zastavok.net/main/komputernye/159708241063.jpg" alt="Товар 1">
            <img src="https://zastavok.net/main/komputernye/159708241063.jpg" alt="Товар 2">
            <img src="https://zastavok.net/main/komputernye/159708241063.jpg" alt="Товар 3">
        </div>
        <button class="slider-btn prev">&#10094;</button>
        <button class="slider-btn next">&#10095;</button>
    </div>
</div>

<!-- Заголовок -->
<h2 class="popular-title">Популярные товары</h2>

<!-- Карточки товаров -->
<div class="products-container">
<?php
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="product-card">';
        echo '<img src="'.htmlspecialchars($row['image']).'" alt="'.htmlspecialchars($row['name']).'">';
        echo '<h3>'.htmlspecialchars($row['name']).'</h3>';
        echo '<p>'.$row['price'].' ₽</p>';
        echo '</div>';
    }
} else {
    echo '<p style="text-align:center; grid-column:1/-1;">Товары отсутствуют</p>';
}
$conn->close();
?>
</div>

<script>
    const slides = document.querySelector('.slides');
    const images = document.querySelectorAll('.slides img');
    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');
    let index = 0;

    function showSlide(i){
        if(i<0) index=images.length-1;
        else if(i>=images.length) index=0;
        else index=i;
        slides.style.transform = `translateX(${-index*100}%)`;
    }
    prev.addEventListener('click',()=>showSlide(index-1));
    next.addEventListener('click',()=>showSlide(index+1));
</script>

</body>
</html>
