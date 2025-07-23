<?php
    $results = [];
    
    // Start with building the base API URL
    $apiUrl = "https://jcollenette.linux.studentwebserver.co.uk/CO7006API/Universities.php";
    
    // Check if the university name is provided
    if (isset($_GET['search_uni']) && !empty($_GET['search_uni'])) {
        $name_uni = urlencode($_GET['search_uni']);
        $apiUrl .= "?name=$name_uni";  // Append name filter if it's provided
    }
    
    // Check if the country is provided
    if (isset($_GET['search_country']) && !empty($_GET['search_country'])) {
        $search_country = urlencode($_GET['search_country']);
        // If name is already in the URL, append country with "&", else use "?" for the first parameter
        $apiUrl .= (strpos($apiUrl, '?') === false ? '?' : '&') . "country=$search_country";
    }
    
    // Make the API request if either filter is provided
    if (isset($_GET['search_uni']) || isset($_GET['search_country'])) {
        $response = file_get_contents($apiUrl);
    
        if ($response !== false) {
            $results = json_decode($response, true);
        }
    }
