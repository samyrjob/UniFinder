<?php
require_once __DIR__ . '/../config/db.php';

$savedUnis = [];

if (isset($_SESSION['user_id'])) {
    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT u.name, u.website, u.country
            FROM user_unis uu JOIN unis u ON uu.uni_id = u.uni_id
            WHERE uu.user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $savedUnis = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Log the error
        error_log("Database error fetching saved universities: " . $e->getMessage());

        echo "<p>Unable to load your saved universities at this time.</p>";
    }
}
