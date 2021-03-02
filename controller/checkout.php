<?php
session_start();
include_once "$_SERVER[DOCUMENT_ROOT]/model/order_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/order_item_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";

if (isset($_POST)) {
    // create order
    $post_data = $_POST["data"];
    $string_id = "";
    foreach ($post_data as $item_data) {
        $cart_item_id = $item_data["cart_item_id"];
        $string_id = $string_id . $cart_item_id . ",";
    }
    $string_id = rtrim($string_id, ",");
    $data = [
        "user_id" => $_SESSION["user"],
        "cart_items_id" => $string_id,
        "total" => $_POST["total"]
    ];
    $order_id = add_order($order_model, $data);
    // 
    $status = true;
    if ($order_id) {
        // create order item
        foreach ($post_data as $item_data) {
            if (!$status) {
                echo json_encode([
                    "location" => ""
                ]);
                exit;
            }
            $cart_item_id = $item_data["cart_item_id"];
            $sub_total = $item_data["sub_total"];
            $cart_item = get_cart_item($cart_item_model, $cart_item_id);
            $data = [
                "order_id" => $order_id,
                "product_id" => $cart_item["product_id"],
                "quantity" => $cart_item["quantity"],
                "color" => $cart_item["color"],
                "size" => $cart_item["size"],
                "sub_total" => $sub_total
            ];
            $order_item = add_order_item($order_item_model, $data);
            // remove($cart_item_model, $cart_item_id);
            if (!$order_item) {
                $status = false;
            }
        }
    }
    echo json_encode([
        "location" => "?route=checkout&&ids=" . $string_id
    ]);
}
