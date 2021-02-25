<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/products.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/construct.php";

$product_model = new Products($conn);

function get_product(string $id, Products $model)
{
    $product_status = $model->get_detail($id);
    if ($product_status['msg'] == 'success') {
        $product = $product_status['data'];
        $variable = $product['variable'];
        if ($variable) {
            $variable = json_decode($variable, true);
            $product['variable'] = $variable;
        } else {
            return "";
        }
        return $product;
    }
    return "";
}

function get_products(Products $model)
{
    $products_status = $model->get_products();
    if ($products_status['msg'] == 'success') {
        $products = $products_status['data'];
        return $products;
    }
    return "";
}
