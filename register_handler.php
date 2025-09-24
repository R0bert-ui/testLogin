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
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = $conn->real_escape_string($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $_SESSION['reg_error'] = "Пожалуйста, заполните все поля.";
        header("Location: register.php");
        exit();
    }

    // Проверим, существует ли уже пользователь
    $check_sql = "SELECT * FROM users WHERE user = '$username' LIMIT 1";
    $check_result = $conn->query($check_sql);
    if ($check_result && $check_result->num_rows > 0) {
        $_SESSION['reg_error'] = "Логин уже занят.";
        header("Location: register.php");
        exit();
    }

    // Добавляем нового пользователя
    $insert_sql = "INSERT INTO users (user, password) VALUES ('$username', '$password')";
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
