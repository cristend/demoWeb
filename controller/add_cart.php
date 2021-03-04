<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";
session_start();
if (!isset($_SESSION['user'])) {
    $url = ltrim($_POST['url'], "/");
    header('Content-Type: application/json');
    echo json_encode([
        'location' => '/user/login.php' . $url
    ]);
} else {
    $uri = $_POST['url'];
    $product_id = explode("id=", $uri)[1];
    $user_id = $_SESSION['user'];
    $cart_id = get_cart_id($cart_model, $user_id);
    add_to_cart($cart_item_model, $cart_id, $product_id, $_POST);
    $data = get_number_item($cart_item_model, $cart_id);
    echo json_encode([
        'location' => '',
        'data' => $data
    ]);
}
