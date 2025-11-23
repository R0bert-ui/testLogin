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

// Получаем категории для фильтра
$catResult = $conn->query("SELECT * FROM categories");

// Получаем выбранную категорию через GET
$category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;

// Получаем товары
if($category_id > 0){
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id=c.id 
            WHERE category_id=$category_id";
} else {
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id=c.id";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TechnoShop</title>
<style>
    * {margin:0; padding:0; box-sizing:border-box;}
    body {font-family: Arial, sans-serif; background-color:#fff; color:#333;}

    /* Верхняя полоса */
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

    /* Нижняя полоса меню */
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

    /* Слайдер */
    .slider-container { max-width:1000px; margin:20px auto; border-radius:10px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.2);}
    .slider { position:relative; width:100%; overflow:hidden; }
    .slides { display:flex; transition: transform 0.5s ease-in-out; }
    .slides img { width:100%; flex-shrink:0; display:block; }
    .slider-btn { position:absolute; top:50%; transform:translateY(-50%); background-color:rgba(0,0,0,0.5); color:white; border:none; padding:10px; cursor:pointer; border-radius:3px; font-size:18px;}
    .prev { left:10px; }
    .next { right:10px; }

    /* Карточки товаров */
    .products-container {
        max-width:1200px;
        margin:20px auto 40px auto;
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        padding: 0 10px;
    }
    .product-card {
        background:#f5f5f5;
        border-radius:10px;
        overflow:hidden;
        box-shadow:0 4px 10px rgba(0,0,0,0.1);
        display:flex;
        flex-direction:column;
        justify-content:space-between;
        transition: transform 0.2s;
    }
    .product-card:hover {transform: translateY(-5px);}
    .product-card img {
        width:100%;
        height:180px;
        object-fit:cover;
        cursor:pointer;
    }
    .product-info {
        padding:10px;
        flex:1;
    }
    .product-info h3 {
        font-size:18px;
        color:#28a745;
        cursor:pointer;
        margin-bottom:5px;
    }
    .product-info p {
        font-size:16px;
        color:#1e7e34;
        font-weight:bold;
        margin-bottom:10px;
    }

    .add-cart-btn {
        background:#28a745;
        color:white;
        border:none;
        padding:10px;
        width:100%;
        font-weight:bold;
        cursor:pointer;
        transition:0.3s;
        border-radius:0 0 10px 10px;
    }
    .add-cart-btn:hover {background:#1e7e34;}
</style>
</head>
<body>

<!-- Верхняя полоса -->
<div class="top-bar">
    <div class="logo">TechnoShop</div>
    <div class="user-panel">
        <?php echo htmlspecialchars($_SESSION['username']); ?>
        <a href="logout.php" class="logout-btn">Выйти</a>
    </div>
</div>

<!-- Нижняя полоса меню -->
<div class="menu-bar">
    <a href="welcome.php">Главная</a>
    <a href="categories.php">Категории</a>
    <a href="cart.php">Корзина</a>
</div>

<!-- Слайдер -->
<div class="slider-container">
    <div class="slider">
        <div class="slides">
            <img src="https://zastavok.net/main/komputernye/159708241063.jpg" alt="Слайд 1">
            <img src="https://zastavok.net/main/komputernye/159708241063.jpg" alt="Слайд 2">
            <img src="https://zastavok.net/main/komputernye/159708241063.jpg" alt="Слайд 3">
        </div>
        <button class="slider-btn prev">&#10094;</button>
        <button class="slider-btn next">&#10095;</button>
    </div>
</div>

<h2 style="text-align:center; margin:30px 0; color:#28a745;">Популярные товары</h2>

<div class="products-container">
<?php
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="product-card">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                 alt="<?php echo htmlspecialchars($row['name']); ?>" 
                 onclick="location.href='product.php?id=<?php echo $row['id']; ?>'">
            <div class="product-info">
                <h3 onclick="location.href='product.php?id=<?php echo $row['id']; ?>'"><?php echo htmlspecialchars($row['name']); ?></h3>
                <p><?php echo $row['price']; ?> тг</p>
            </div>
            <form method="post" action="add_to_cart.php">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="add-cart-btn">Добавить в корзину</button>
            </form>
        </div>
        <?php
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
