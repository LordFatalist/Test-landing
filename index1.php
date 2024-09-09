<?php
try {
    $pdo = new PDO('sqlite:db/database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM users");

    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Тип формы</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Услуга</th>
            <th>Цена</th>
            <th>Комментарии</th>
          </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['form_type']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['select_service']) . "</td>";
        echo "<td>" . htmlspecialchars($row['select_price']) . "</td>";
        echo "<td>" . htmlspecialchars($row['comments']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
