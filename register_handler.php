<?php
session_start();

$servername = "localhost";
$dbname = "testlogin";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $_SESSION['reg_error'] = "Пожалуйста, заполните все поля.";
        header("Location: register.php");
        exit();
    }

    // Проверка длины логина
    if (mb_strlen($username) < 4 || mb_strlen($username) > 16) {
        $_SESSION['reg_error'] = "Логин должен быть от 4 до 16 символов.";
        header("Location: register.php");
        exit();
    }

    // Проверка длины пароля
    if (mb_strlen($password) < 8 || mb_strlen($password) > 16) {
        $_SESSION['reg_error'] = "Пароль должен быть от 8 до 16 символов.";
        header("Location: register.php");
        exit();
    }

    $username_esc = $conn->real_escape_string($username);

    $check_sql = "SELECT * FROM users WHERE user = '$username_esc' LIMIT 1";
    $check_result = $conn->query($check_sql);
    if ($check_result && $check_result->num_rows > 0) {
        $_SESSION['reg_error'] = "Логин уже занят.";
        header("Location: register.php");
        exit();
    }

    $password_esc = $conn->real_escape_string($password);

    $insert_sql = "INSERT INTO users (user, password) VALUES ('$username_esc', '$password_esc')";
    if ($conn->query($insert_sql) === TRUE) {
        $_SESSION['reg_success'] = "Регистрация успешна! Теперь вы можете войти.";
        header("Location: register.php");
        exit();
    } else {
        $_SESSION['reg_error'] = "Ошибка регистрации: " . $conn->error;
        header("Location: register.php");
        exit();
    }
}

$conn->close();
?>


