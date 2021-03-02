<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/order_items.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/construct.php";

$order_item_model = new OrderItems($conn);

function add_order_item(OrderItems $model)
{
    $cart_id = $model->add([]);
}
