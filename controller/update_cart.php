<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";
session_start();
if (isset($_POST)) {
    $data = $_POST['data'];
    foreach ($data as $cart_item) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        $data = [
            "quantity" => $quantity,
            "color" => $cart_item["color"],
            "size" => $cart_item["size"]
        ];
        update_quantity($cart_item_model, $data, $product_id);
    }
}
