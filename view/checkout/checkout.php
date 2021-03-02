<?php
if (isset($_GET) || !isset($_SESSION['user'])) {
    if ($_SERVER["DOCUMENT_URI"] != "/index.php") {
        header("Location: /404.php");
        exit();
    }
}
include_once "$_SERVER[DOCUMENT_ROOT]/model/user_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/product_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_model.php";

$user_id = $_SESSION['user'];
$user = get_user($user_id, $user_model);
$cart_id = get_cart_id($cart_model, $id);
$cart_items = get_cart_items($cart_item_model, $cart_id);
// js calculation
?>
<link rel="stylesheet" , href="/static/css/cart.css">
<script>

</script>
<div class="container bootdey">
    <div class="row bootstrap snippets">
        <div class="clearfix visible-sm"></div>

        <!-- Cart -->
        <div class="col-lg-9 col-md-9 col-sm-12">
            <div class="col-lg-12 col-sm-12">
                <span class="title">BILLING</span>
            </div>
            <div class="col-lg-12 col-sm-12 hero-feature">
                <div class="table-responsive">
                    <table class="table table-bordered tbl-cart">
                        <thead>
                            <tr>
                                <td class="hidden-xs">Image</td>
                                <td>Product Name</td>
                                <td>Color</td>
                                <td>Size</td>
                                <td class="td-qty">Quantity</td>
                                <td>Unit Price ($)</td>
                                <td>Sub Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $total = 0;
                            foreach ($cart_items as $cart_item) {
                                $product_id = $cart_item['product_id'];
                                $product = get_product($product_id, $product_model);
                                $price = (floatval($product['price'])) * $cart_item['quantity'];
                                $total = $total + $price;
                            ?>
                                <tr id="product<?php echo $count; ?>" class="product-cart" name="<?php echo $product_id; ?>">
                                    <td class="hidden-xs">
                                        <a href="#">
                                            <img src="<?php echo $product['image']; ?>" alt="" title="" width="47" height="47">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#"><?php echo $product['title']; ?></a>
                                    </td>
                                    <td class="product-checkout product-checkout-color">
                                        <?php echo $cart_item['color']; ?>
                                    </td>
                                    <td class="product-checkout product-checkout-size">
                                        <?php echo $cart_item['size']; ?>
                                    </td>
                                    <td class="item-quantity product-checkout">
                                        <?php echo $cart_item['quantity']; ?>
                                    </td>
                                    <td class="price"><?php echo $product['price']; ?></td>
                                    <td class="total"><?php echo number_format((float)$price, 2, '.', ''); ?></td>
                                </tr>
                            <?php
                                $count = $count + 1;
                            }
                            ?>
                            <tr class="product-cart">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td id="total"><?php echo number_format((float)$total, 2, '.', ''); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn-group btns-cart">
                    <a href="/"><button type="button" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i>Continue Shopping</button></a>
                </div>

            </div>
        </div>
        <!-- End Cart -->
    </div>
</div>