<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";
session_start();
if (!isset($_SESSION['user'])) {
    $url = ltrim($_POST['url'], "/");
    header('Content-Type: application/json');
    echo json_encode([
        'location' => '/login.php' . $url
    ]);
} else {
    $uri = $_POST['url'];
    $product_id = explode("id=", $uri)[1];
    $user_id = $_SESSION['user'];
    $cart_id = get_cart_id($cart_model, $user_id);
    $quantity = $_POST['quantity'];
    add_to_cart($cart_item_model, $cart_id, $product_id, $quantity);
    $data = get_number_item($cart_item_model);
    //
    echo json_encode([
        'location' => '',
        'data' => $data
    ]);
    // 
}
