<?php
$uri = $_SERVER["REQUEST_URI"];
if ($uri == "/index.php") {
    header("Location: /");
    exit();
}
session_start();
include_once "$_SERVER[DOCUMENT_ROOT]/view/home/header.php";
// main block
// default home page (not login) nav
if (!isset($_SESSION['user'])) {
    $user_id = null;
    include_once "$_SERVER[DOCUMENT_ROOT]/view/home/nav_default.php";
} else {
    // logined home nav
    $user_id = $_SESSION['user'];
    include_once "$_SERVER[DOCUMENT_ROOT]/view/home/nav_logined.php";
}
// main content

if (isset($_GET['route'])) {
    $route = $_GET['route'];
    if ($route == 'product_detail') {
        include_once "$_SERVER[DOCUMENT_ROOT]/view/product/product_detail.php";
    } elseif ($route == 'cart') {
        include_once "$_SERVER[DOCUMENT_ROOT]/view/cart/cart.php";
    } elseif ($route == 'checkout') {
        include_once "$_SERVER[DOCUMENT_ROOT]/view/checkout/checkout.php";
    } elseif ($route == 'user_profile') {
        include_once "$_SERVER[DOCUMENT_ROOT]/view/user/user.php";
        include_once "$_SERVER[DOCUMENT_ROOT]/view/user/profile.php";
    } elseif ($route == 'user_history') {
        include_once "$_SERVER[DOCUMENT_ROOT]/view/user/user.php";
        include_once "$_SERVER[DOCUMENT_ROOT]/view/user/history.php";
    } elseif ($route == 'user_edit'){
        include_once "$_SERVER[DOCUMENT_ROOT]/view/user/user.php";
        include_once "$_SERVER[DOCUMENT_ROOT]/view/user/edit_profile.php";
    }
} else {
    // default main content
    include_once "$_SERVER[DOCUMENT_ROOT]/view/product/product.php";
}
// 
include_once "$_SERVER[DOCUMENT_ROOT]/view/home/footer.php";
