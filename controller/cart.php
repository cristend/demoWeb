<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";
if (isset($_POST)) {
    $cart_item_id = $_POST["cart_item_id"];
    remove($cart_item_model, $cart_item_id);
    echo "''=>''";
}
if (isset($_GET)) {
}
