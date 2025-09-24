<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: welcome.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<title>Регистрация</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .register-form {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        width: 320px;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #555;
        font-size: 14px;
    }

    input {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #28a745;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
    }

    button:hover {
        background-color: #218838;
    }

    .link {
        text-align: center;
        margin-top: 15px;
    }

    .link a {
        color: #3366cc;
        text-decoration: none;
    }

    .error {
        color: #cc3333;
        margin-bottom: 15px;
        text-align: center;
        font-size: 14px;
    }

    .success {
        color: #28a745;
        margin-bottom: 15px;
        text-align: center;
        font-size: 14px;
    }
</style>
</head>
<body>

<div class="register-form">
    <h2>Регистрация</h2>

    <?php if (!empty($_SESSION['reg_error'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['reg_error']) ?></div>
        <?php unset($_SESSION['reg_error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['reg_success'])): ?>
        <div class="success"><?= htmlspecialchars($_SESSION['reg_success']) ?></div>
        <?php unset($_SESSION['reg_success']); ?>
    <?php endif; ?>

    <form action="register_handler.php" method="POST">
        <div class="form-group">
            <label for="username">Логин:</label>
            <input type="text" id="username" name="username" required placeholder="Придумайте логин" />
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required placeholder="Придумайте пароль" />
        </div>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <div class="link">
        Уже есть аккаунт? <a href="index.php">Войти</a>
    </div>
</div>

</body>
</html>
