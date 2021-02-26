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

function paging(Products $model, $page = 1)
{
    $limit = 9;
    $offset = $limit * ($page - 1);
    $pages_status = $model->get_page($limit, $offset);
    if (($pages_status)['msg'] == 'success') {
        return $pages_status['data'];
    }
    return "";
}

function get_page(Products $model)
{
    $count = $model->count_products();
    $pages = ceil($count / 9);
    return $pages;
}
