<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/carts.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/construct.php";

$cart_model = new Carts($conn);

function add_cart(Carts $model, $user_id)
{
    $cart_id = $model->add($user_id);
    if ($cart_id['msg'] == 'success') {
        $cart_id = $cart_id['data'];
        return $cart_id;
    }
    return "";
}

function get_cart_id(Carts $model, $user_id)
{
    $cart = $model->get_cart($user_id);
    if ($cart['msg'] == 'success') {
        $cart = $cart['data'];
        return $cart['id'];
    }
}
// function update_cart(Carts $model, $cart_id, $product_id)
// {
//     $data = [""];
//     $model->update($cart_id, $data);
// }
