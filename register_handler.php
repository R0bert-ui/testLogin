<?php
session_start();

$servername = "localhost";
$dbname = "testlogin";
$dbusername = "root";
$dbpassword = "";

// Подключение к базе
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем данные из формы
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Проверка на пустые поля
if (!$username || !$password) {
    $_SESSION['reg_error'] = "Пожалуйста, заполните все поля!";
    header("Location: register.php");
    exit();
}

// Минимальная длина
if (strlen($username) < 6) {
    $_SESSION['reg_error'] = "Логин должен быть не менее 6 символов!";
    header("Location: register.php");
    exit();
}

if (strlen($password) < 8 || !preg_match('/\d/', $password)) {
    $_SESSION['reg_error'] = "Пароль должен быть не менее 8 символов и содержать хотя бы одну цифру!";
    header("Location: register.php");
    exit();
}

// Проверка уникальности логина
$stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['reg_error'] = "Такой логин уже существует!";
    header("Location: register.php");
    exit();
}
$stmt->close();

// Вставка нового пользователя (без хэширования)
$role = 'user'; // по умолчанию пользователь
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    $_SESSION['reg_success'] = "Регистрация прошла успешно! Теперь войдите.";
    header("Location: index.php");
} else {
    $_SESSION['reg_error'] = "Ошибка регистрации: " . $conn->error;
    header("Location: register.php");
}

$stmt->close();
$conn->close();
