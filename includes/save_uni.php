<?php

    require_once __DIR__ . '/../config/db.php';
    
    
    $saveUni = '';
    $savedUnis = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_university']) && isset($_SESSION['user_id'])) {
        try {
            $pdo = getPDO();
    
            $name = $_POST['name'];
            $website = $_POST['website'];
            $country = $_POST['country'];
            $user_id = $_SESSION['user_id'];
            
    
            //  Check for existing entry of this university
            $stmt = $pdo->prepare("SELECT uni_id FROM unis WHERE name = ?");
            $stmt->execute([$name]);
            $uni = $stmt->fetch();
    
            if (!$uni) {
                // Insert the new university into the unis table
                $stmt = $pdo->prepare("INSERT INTO unis (name, website, country) VALUES (?, ?, ?)");
                $stmt->execute([$name, $website, $country]);
                $uni_id = $pdo->lastInsertId();
            } else {
                $uni_id = $uni['uni_id'];
            }
    
            // Link the university to the user (user_unis table)
            $stmt = $pdo->prepare("INSERT IGNORE INTO user_unis (user_id, uni_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $uni_id]);
    
            $saveUni = "'$name' saved to your list.";
    
        } catch (PDOException $e) {
            $saveUni = "Error: " . $e->getMessage();
        }
    }

    if (isset($_SESSION['user_id'])) {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT u.name, u.website,  u.country
                FROM user_unis uu
                JOIN unis u ON uu.uni_id = u.uni_id
                WHERE uu.user_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $savedUnis = $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            echo "<p>Something went wrong while fetching your saved universities.</p>";
        }
    