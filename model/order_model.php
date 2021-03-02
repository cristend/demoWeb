<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/orders.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/construct.php";

$order_model = new Orders($conn);

function add_order(Orders $model, $data)
{
    $order = $model->add($data);
    if ($order['msg'] == 'success') {
        $order_id = $order['data'];
        return $order_id;
    }
    return "";
}

function get_orders_by_id(Orders $model, $order_ids)
{
    $orders = [];
    $status = true;
    foreach ($order_ids as $order_id) {
        if (!$status) {
            return [];
        }
        $order = get_order_by_id($model, $order_id);
        if ($order) {
            array_push($orders, $order);
        } else {
            $status = false;
        }
    }
    return $orders;
}
function get_order_by_id(Orders $model, $order_id)
{
    $model->get_order_by_id($order_id);
    if ($model['msg']) {
        return $model['data'];
    }
    return "";
}

function find_orders(Orders $model, $user_id)
{
    $orders = $model->find_order($user_id);
    if ($orders['msg'] == 'success') {
        return $orders['data'];
    }
    return [];
}

function find_order_ids(Orders $model, $user_id)
{
    $order_ids = [];
    $orders = find_orders($model, $user_id);
    if ($orders) {
        foreach ($orders as $order) {
            array_push($order_ids, $order["id"]);
        }
    }
    return $order_ids;
}
