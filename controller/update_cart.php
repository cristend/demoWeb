<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";
session_start();
if (isset($_POST)) {
    $data = $_POST['data'];
    foreach ($data as $cart_item) {
        $cart_item_id = $cart_item["cart_item_id"];
        $data = [
            "quantity" => $cart_item['quantity']
        ];
        update_quantity($cart_item_model, $data, $cart_item_id);
    }
}
