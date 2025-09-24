<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Добро пожаловать</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        flex-direction: column;
        color: #333333;
    }

    h1 {
        margin-bottom: 20px;
        font-weight: 600;
    }

    a.logout-btn {
        background-color: #3366cc;
        color: white;
        padding: 12px 25px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    a.logout-btn:hover {
        background-color: #254d99;
    }
</style>
</head>
<body>

<h1>Добро пожаловать, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
<a href="logout.php" class="logout-btn">Выйти</a>

</body>
</html>

