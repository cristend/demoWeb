<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/order_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/product_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/order_item_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";

$user_id = $_SESSION["user"];
$orders = find_orders($order_model, $user_id);

?>
    <div class="col-md-9">
        <?php
        foreach ($orders as $order) {
        ?>
            <div>Order ID: #<?php echo $order["id"]; ?>
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
                            $filter = ["order_id" => $order["id"]];
                            $order_items = get_order_items_by_filter($order_item_model, $filter);
                            if ($order_items) {
                                foreach ($order_items as $order_item) {
                                    $product_id = $order_item["product_id"];
                                    $product = get_product($product_id, $product_model);
                            ?>
                                    <tr>
                                        <td class="hidden-xs">
                                            <a href="#">
                                                <img src="<?php echo $product['image']; ?>" alt="" title="" width="47" height="47">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="?route=product_detail&&id=<?php echo $product_id; ?>"><?php echo $product['title']; ?></a>
                                        </td>
                                        <td class="product-checkout product-checkout-color">
                                            <?php echo $order_item['color']; ?>
                                        </td>
                                        <td class="product-checkout product-checkout-size">
                                            <?php echo $order_item['size']; ?>
                                        </td>
                                        <td class="item-quantity product-checkout">
                                            <?php echo $order_item['quantity']; ?>
                                        </td>
                                        <td class="price"><?php echo $product['price']; ?></td>
                                        <td class="total"><?php echo $order_item["sub_total"]; ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                            <tr class="product-cart">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td id="total"><?php echo $order["total"]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>