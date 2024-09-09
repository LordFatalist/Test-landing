<?php
try {
    $pdo = new PDO('sqlite:db/database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("DROP TABLE IF EXISTS users");
    
    $sql = "CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                form_type TEXT NOT NULL,
                name TEXT NOT NULL,
                last_name TEXT NOT NULL,
                phone TEXT NOT NULL,
                email TEXT NOT NULL,
                select_service TEXT NOT NULL,
                select_price TEXT NOT NULL,
                comments TEXT
            )";
    $pdo->exec($sql);

    echo "Таблица users успешно пересоздана.";
} catch (PDOException $e) {
    echo "Ошибка при создании таблицы: " . $e->getMessage();
}
?>

