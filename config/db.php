<?php
function getPDO() {
    
    try {
         $pdo = new PDO("mysql:host=localhost;dbname=c2427448_search_universities","c2427448_assignmentUser", "PleaseDontHackMe");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
        
        
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
   
}
