<?php
require_once __DIR__ . '/../config/db.php';

$saveUni = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_university']) && isset($_SESSION['user_id'])) {
    try {
        $pdo = getPDO();

        $uni_name = $_POST['uni_name'];
        $user_id = $_SESSION['user_id'];

        // Get uni_id
        $stmt = $pdo->prepare("SELECT uni_id FROM unis WHERE name = ?");
        $stmt->execute([$uni_name]);
        $uni = $stmt->fetch();

        if ($uni) {
            $stmt = $pdo->prepare("DELETE FROM user_unis WHERE user_id = ? AND uni_id = ?");
            $stmt->execute([$user_id, $uni['uni_id']]);
            $saveUni = "'$uni_name' removed from the list.";
        }
    } catch (PDOException $e) {
        $saveUni = "Error: " . $e->getMessage();
    }
}
