<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/cart_items.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/construct.php";

$cart_item_model = new CartItems($conn);

function add_item(CartItems $model, $cart_id, $product_id, array $array)
{
    $data = [
        "cart_id" => $cart_id,
        "product_id" => $product_id,
        "quantity" => $array['quantity'],
        "color" => $array['color'],
        "size" => $array['size']
    ];
    $model->add($data);
}
function add_to_cart(CartItems $model, $cart_id, $product_id, $data)
{
    $quantity = $data['quantity'];
    $cart_item = $model->get_cart_item_or_fail($product_id, $cart_id, $data);
    if ($cart_item) {
        $new_quantity = (int)$cart_item['quantity'] + $quantity;
        $data = [
            "quantity" => $new_quantity,
            "color" => $data["color"],
            "size" => $data["size"]
        ];
        update_quantity($model, $data, $product_id);
    } else {
        add_item($model, $cart_id, $product_id, $data);
    }
}

function update_quantity(CartItems $model, $data, $product_id)
{
    $model->edit_quantity($data, $product_id);
}

function get_number_item(CartItems $model, $cart_id)
{
    $count = $model->count_item($cart_id);
    return $count;
}

function get_cart_items(CartItems $model, $cart_id)
{
    $cart_items = $model->get_cart_items($cart_id);
    if ($cart_items['msg'] == 'success') {
        return $cart_items['data'];
    }
    return [];
}

function remove(CartItems $model, array $array)
{
    $model->remove($array);
}
