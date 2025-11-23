<?php
session_start();

// Подключение к базе данных
$servername = "localhost";
$dbname = "testlogin";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username === '' || $password === '') {
        $_SESSION['error'] = "Пожалуйста, заполните все поля.";
        header("Location: index.php");
        exit();
    }

    $username_safe = $conn->real_escape_string($username);

    $sql = "SELECT username, role, password FROM users WHERE username='$username_safe' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($row['password'] === $password) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: welcome.php");
            exit();
        } else {
            $_SESSION['error'] = "Неверный пароль.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Пользователь не найден.";
        header("Location: index.php");
        exit();
    }
}

$conn->close();
?>
