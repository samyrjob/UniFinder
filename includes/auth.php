<?php
require_once __DIR__ . '/../config/db.php';

$loginMessage = '';
$alreadyUsed = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // login logic
        $username = trim($_POST['username']);
        $password = $_POST['password'];   // get the password

        if (!empty($username) && !empty($password)) {
            try {
                $pdo = getPDO(); // Use the centralized DB connection
        
                // Check if user exists
                $stmt = $pdo->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
        
                if (!$user) {
                    // No user found with that username
                    $loginMessage = "User not found.";
                } elseif (!password_verify($password, $user['password'])) {
                    // User exists but password is wrong
                    $loginMessage = "Incorrect password.";
                } else {
                    // Login successful
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_id'] = $user['user_id'];
            
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }
        
            } catch (PDOException $e) {
                $loginMessage = "Error logging in: " . $e->getMessage();
            }
        }
        
    }  elseif (isset($_POST['sign_up']) && !empty($_POST['create_user'])) {
        // sign up logic
        
        $new_username = trim($_POST['create_user']);
        $password = $_POST['password']; // Get the password
        $alreadyUsed = '';
        
        if (!empty($new_username) && !empty($password)) {
            try {
                $pdo = getPDO(); // Use centralized DB connection
        
                // Check if username already exists
                $stmt = $pdo->prepare("SELECT user_id FROM users WHERE username = ?");
                $stmt->execute([$new_username]);
                $existing = $stmt->fetch();
        
                if ($existing) {
                    $alreadyUsed = "Username already taken. Please choose another.";
                } else {
                    
                    
                    // Hash the password before saving it
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Create new user and its password

                    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                    $stmt->execute([$new_username, $hashedPassword]);
                    
                    
                    
                    $user_id = $pdo->lastInsertId();
                    $_SESSION['username'] = $new_username;
                    $_SESSION['user_id'] = $user_id;
        
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }
            } catch (PDOException $e) {
                $alreadyUsed = "Error signing up: " . $e->getMessage();
            }
        }

        
        
        
        
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
