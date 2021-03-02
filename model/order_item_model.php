<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/order_items.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/construct.php";

$order_item_model = new OrderItems($conn);

function add_order_item(OrderItems $model, $data)
{
    $order_item = $model->add($data);
    if ($order_item['msg'] == 'success') {
        $order_item_id = $order_item['data'];
        return $order_item_id;
    }
    return "";
}

function get_order_items_by_filter(OrderItems $model, array $filter)
{
    $order_items = $model->get_order_items_by_filter($filter);
    if ($order_items['msg'] == 'success') {
        return $order_items['data'];
    }
    return [];
}
