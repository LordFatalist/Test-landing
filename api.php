<?php
session_start(); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(["success" => false, "message" => "Ошибка CSRF-токена."]);
        exit;
    }

    $form_type = isset($_POST['form_type']) ? $_POST['form_type'] : '';
    $name = htmlspecialchars($_POST['first_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $last_name = htmlspecialchars($_POST['last_name'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8');
    $select_service = htmlspecialchars($_POST['select_service'] ?? '', ENT_QUOTES, 'UTF-8');
    $select_price = htmlspecialchars($_POST['select_price'] ?? '', ENT_QUOTES, 'UTF-8');
    $comments = htmlspecialchars($_POST['comments'] ?? '', ENT_QUOTES, 'UTF-8');

    if (empty($name) || empty($last_name) || empty($email) || empty($phone)) {
        echo json_encode(["success" => false, "message" => "Пожалуйста, заполните все обязательные поля."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Некорректный формат email."]);
        exit;
    }

    try {
        $pdo = new PDO('sqlite:db/database.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO users (form_type, name, last_name, email, phone, select_service, select_price, comments) 
                VALUES (:form_type, :name, :last_name, :email, :phone, :select_service, :select_price, :comments)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':form_type' => $form_type,
            ':name' => $name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':phone' => $phone,
            ':select_service' => $select_service,
            ':select_price' => $select_price,
            ':comments' => $comments
        ]);

        echo json_encode(["success" => true, "message" => "Данные успешно сохранены!"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Ошибка базы данных: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Некорректный запрос."]);
}
exit;



