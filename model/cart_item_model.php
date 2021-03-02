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

function update_quantity(CartItems $model, $data, $cart_item_id)
{
    $model->edit_quantity($data, $cart_item_id);
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
function get_cart_item(CartItems $model, $cart_item_id)
{
    $cart_item = $model->get_cart_item($cart_item_id);
    if ($cart_item['msg'] == 'success') {
        return $cart_item['data'];
    }
    return [];
}
function get_cart_by_ids(CartItems $model, $cart_items_id)
{
    $cart_items = [];
    $status = true;
    foreach ($cart_items_id as $cart_item_id) {
        $cart_item = $model->get_cart_item($cart_item_id);
        if (!$status) {
            return [];
        }
        if ($cart_item['msg'] == 'success') {
            array_push($cart_items, $cart_item['data']);
        } else {
            $status = false;
        }
    }
    return $cart_items;
}

function remove(CartItems $model, $cart_item_id)
{
    $model->remove($cart_item_id);
}
