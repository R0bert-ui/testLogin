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
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Вход в систему</title>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-form {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        width: 320px;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333333;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #555555;
        font-size: 14px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #cccccc;
        border-radius: 4px;
        font-size: 15px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: #3366cc;
        outline: none;
        box-shadow: 0 0 6px rgba(51, 102, 204, 0.4);
    }

    button {
        width: 100%;
        padding: 12px;
        background-color:#28a745;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-weight: 600;
    }

    button:hover {
        background-color:#218838;
    }

    .error {
        color: #cc3333;
        margin-bottom: 15px;
        text-align: center;
        font-size: 14px;
    }
    .link {
        text-align: center;
        margin-top: 15px;
    }

    .link a {
        color: #3366cc;
        text-decoration: none;
    }
</style>
</head>
<body>

<div class="login-form">
    <h2>Вход в систему</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Логин:</label>
            <input type="text" id="username" name="username" required placeholder="Введите логин" />
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required placeholder="Введите пароль" />
        </div>

        <button type="submit">Войти</button>
        <div class="link" style="text-align:center; margin-top:15px;">
    Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
</div>

    </form>
</div>

</body>
</html>


