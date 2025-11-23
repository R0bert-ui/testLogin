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
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $_SESSION['error'] = "Пожалуйста, заполните все поля.";
        header("Location: index.php");
        exit();
    }
    $sql = "SELECT password FROM users WHERE user = '$username' LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($row['password'] === $password) {
            $_SESSION['username'] = $username;
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

