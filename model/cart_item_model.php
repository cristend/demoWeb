<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/cart_items.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/construct.php";

$cart_item_model = new CartItems($conn);

function add_item(CartItems $model, $cart_id, $product_id, $quantity)
{
    $data = [
        "cart_id" => $cart_id,
        "product_id" => $product_id,
        "quantity" => $quantity
    ];
    $model->add($data);
}
function add_to_cart(CartItems $model, $cart_id, $product_id, $quantity)
{
    $cart_item = $model->get_cart_item_or_fail($product_id);
    if ($cart_item) {
        $new_quantity = (int)$cart_item['quantity'] + $quantity;
        $data = ["quantity" => $new_quantity];
        update_item($model, $data, $product_id);
    } else {
        add_item($model, $cart_id, $product_id, $quantity);
    }
}

function update_item(CartItems $model, $data, $product_id)
{
    $model->edit($data, $product_id);
}

function get_number_item(CartItems $model)
{
    $count = $model->count_item();
    return $count;
}
