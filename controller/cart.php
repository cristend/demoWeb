<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";
if (isset($_POST)) {
    remove($cart_item_model, $_POST);
    echo "''=>''";
}
if (isset($_GET)) {
}
