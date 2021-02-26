<?php
session_start();
if (!isset($_SESSION['user'])) {
    $url = ltrim($_POST['url'], "/");
    header('Content-Type: application/json');
    echo json_encode([
        'location' => '/login.php' . $url
    ]);
} else {
    $uri = $_POST['url'];
    $id = explode("id=", $uri)[1];
    // 
}
