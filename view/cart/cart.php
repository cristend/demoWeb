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
    $(function() {
        var products = $(".product-cart td input[checked='checked']");
        sum_total(products);
        $(".product-btn-minus").on("click", function() {
            var button = event.target;
            var index = button.name;
            var element = ".item-quantity > div > input[name=quantity" + index + "]";
            var input = $(element);
            element = "#product" + index + " > .price";
            var price = $(element)[0];
            element = "#product" + index + " > .total";
            var total = $(element)[0];
            if ($.isNumeric(price.innerText)) {
                price = parseFloat(price.innerText)
            }
            var now = input.val();
            if ($.isNumeric(now) && now > 1) {
                if (parseInt(now) - 1 > 0) {
                    now--;
                }
                input.val(now);
                var total_now = (parseInt(now) * price).toFixed(2);
                total.innerText = total_now;
            } else {
                input.val("1");
                total.innerText = price;
            }
            var elements = $(".product-cart td input[checked='checked']");
            sum_total(elements);
        });

        $(".product-btn-plus").on("click", function() {
            var button = event.target;
            var index = button.name;
            var element = ".item-quantity > div > input[name=quantity" + index + "]";
            var input = $(element);
            element = "#product" + index + " > .price";
            var price = $(element)[0];
            element = "#product" + index + " > .total";
            var total = $(element)[0];
            if ($.isNumeric(price.innerText)) {
                price = parseFloat(price.innerText)
            }
            var now = input.val();
            if ($.isNumeric(now) && now >= 1) {
                now++;
                input.val(now);
                var total_now = (parseInt(now) * price).toFixed(2);
                total.innerText = total_now;
            } else {
                input.val("1");
                total.innerText = price;
            }
            var elements = $(".product-cart td input[checked='checked']");
            sum_total(elements);
        });

        $(".check-all").click(function() {
            var checkedState = $(this).attr('checked');
            if (!checkedState) {
                checkedState = false;
                $(this).attr("checked", "checked");
            } else {
                $(this).attr("checked", false);
            }
            $(".check-one").each(function() {
                if (checkedState) {
                    $(this).prop('checked', false);
                    $(this).attr('checked', false);
                } else {
                    $(this).prop('checked', "checked");
                    $(this).attr('checked', "checked");
                }
            });
            var elements = $(".product-cart td input[checked='checked']");
            sum_total(elements);
        });

        $(".check-one").click(function() {
            var checkedState = $(this).attr('checked');
            if (!checkedState) {
                checkedState = false;
                $(this).attr("checked", "checked");
            } else {
                $(this).attr("checked", false);
            }
            var elements = $(".product-cart td input[checked='checked']");
            sum_total(elements);
        });

        $(".input-qty").on("change", function() {
            var now = $(this).val();
            var ancestor = $(this)[0].parentNode.parentNode;
            var price = ancestor.nextElementSibling;
            var sub_total = price.nextElementSibling;
            if (!$.isNumeric(now) || ($.isNumeric(now) && parseInt(now) < 1)) {
                $(this).val("1");
                sub_total.innerText = price.innerText;
            } else {
                total = parseInt(now) * parseFloat(price.innerText);
                sub_total.innerText = total.toFixed(2);
            }
            var elements = $(".product-cart td input[checked='checked']");
            sum_total(elements);
        });

        $(".remove-product").on("click", function() {
            if (confirm("Are you sure.")) {
                var button = event.target;
                var index = event.target.name;
                var cart_item = $("#product" + index);
                cart_item_id = cart_item[0].getAttribute("name");
                $.ajax({
                    type: "POST",
                    url: "/controller/cart.php",
                    data: {
                        'cart_item_id': cart_item_id
                    },
                    success: function(response) {
                        cart_item.remove();
                        var elements = $(".product-cart td input[checked='checked']");
                        sum_total(elements);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });
            };
        })
        $(".update-cart").on("click", function() {
            var data = update_cart();
            $.ajax({
                type: "POST",
                url: "/controller/update_cart.php",
                data: {
                    'data': data
                },
                success: function(response) {
                    alert("update success!")
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
        $(".checkout").on("click", function() {
            // update cart
            data = update_cart();
            $.ajax({
                type: "POST",
                url: "/controller/update_cart.php",
                data: {
                    'data': data
                },
                success: function(response) {

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
            // create order
            var elements = $(".product-cart td input[checked='checked']");
            if (elements.length == 0) {
                alert("Please select at least product!");
                return false;
            }
            var cart_items_id = [];
            // console.log(elements);
            [].forEach.call(elements, function(v, i, a) {
                var index = v.name;
                var cart_item = $("#product" + index);
                if (cart_item.find(".total")[0] === undefined) {} else {
                    var sub_total = cart_item.find(".total")[0].innerText;
                    var cart_item_id = $(cart_item)[0].getAttribute("name");
                    if (cart_item_id === undefined) {} else {
                        cart_items_id.push({
                            cart_item_id: cart_item_id,
                            sub_total: sub_total
                        });
                    }
                }
            });
            $.ajax({
                type: "POST",
                url: "/controller/checkout.php",
                dataType: "json",
                data: {
                    'data': cart_items_id,
                    'total': $("#total")[0].innerText,
                },
                success: function(response) {
                    if (response.location) {
                        window.location.href = response.location;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
    });

    function update_cart() {
        var cart_id = $("#cart")[0].getAttribute("name");
        var products = $(".product-cart");
        var quantity = 0;
        var cart_item_id = "";
        var data = [];
        console.log(products);
        [].forEach.call(products, function(v, i, a) {
            var array = [];
            cart_item_id = v.getAttribute("name")
            quantity = $(v).find(".item-quantity div input")[0];
            if (quantity === undefined) {

            } else {
                array.quantity = $(quantity).val();
                array.cart_item_id = cart_item_id;
                data[i] = {
                    ...array
                };
            }
        });
        return data;
    }

    function sum_total(elements) {
        var total = 0;
        [].forEach.call(elements, function(v, i, a) {
            var node = null;
            var ancestor = v.parentNode.parentNode;
            for (let index = 0; index < ancestor.childNodes.length; index++) {
                if (ancestor.childNodes[index].className == "total") {
                    node = ancestor.childNodes[index];
                    break;
                }
            }
            if (node === null) {
                return;
            }
            total = total + parseFloat(node.innerText);
        });
        $("#total")[0].innerText = total.toFixed(2);
    }
</script>
<div class="container bootdey">
    <div class="row bootstrap snippets">
        <div class="clearfix visible-sm"></div>

        <!-- Cart -->
        <div class="col-lg-9 col-md-9 col-sm-12">
            <div class="col-lg-12 col-sm-12">
                <span id="cart" name="<?php echo $cart_id; ?>" class="title">SHOPPING CART</span>
            </div>
            <div class="col-lg-12 col-sm-12 hero-feature">
                <div class="table-responsive">
                    <table class="table table-bordered tbl-cart">
                        <thead>
                            <tr>
                                <td></td>
                                <td class="hidden-xs">Image</td>
                                <td>Product Name</td>
                                <td>Color</td>
                                <td>Size</td>
                                <td class="td-qty">Quantity</td>
                                <td>Unit Price ($)</td>
                                <td>Sub Total</td>
                                <td>Remove</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            foreach ($cart_items as $cart_item) {
                                $product_id = $cart_item['product_id'];
                                $product = get_product($product_id, $product_model);
                                $price = (floatval($product['price'])) * $cart_item['quantity'];
                            ?>
                                <tr id="product<?php echo $count; ?>" class="product-cart" name="<?php echo $cart_item["id"]; ?>">
                                    <td class="cart-checkbox"><input class="check-one" type="checkbox" name="<?php echo $count; ?>"></td>
                                    <td class="hidden-xs">
                                        <a href="#">
                                            <img src="<?php echo $product['image']; ?>" alt="" title="" width="47" height="47">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/?route=product_detail&&id=<?php echo $product_id; ?>"><?php echo $product['title']; ?></a>
                                    </td>
                                    <td class="product-color">
                                        <select name="color">
                                            <option value="<?php echo $cart_item['color']; ?>"><?php echo $cart_item['color']; ?></option>
                                        </select>
                                    </td>
                                    <td class="product-size">
                                        <select name="size">
                                            <option value="<?php echo $cart_item['size']; ?>"><?php echo $cart_item['size']; ?></option>
                                        </select>
                                    </td>
                                    <td class="item-quantity">
                                        <div class="input-group bootstrap-touchspin">
                                            <span class="input-group-btn">
                                                <button name="<?php echo $count; ?>" class="btn product-btn-minus btn-default bootstrap-touchspin-down" type="button">-</button>
                                            </span>
                                            <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                                            <input type="text" name="quantity<?php echo $count; ?>" value="<?php echo $cart_item['quantity']; ?>" class="input-qty form-control text-center" style="display: block;">
                                            <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
                                            <span class="input-group-btn">
                                                <button name="<?php echo $count; ?>" class="btn product-btn-plus btn-default bootstrap-touchspin-up" type="button">+</button>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="price"><?php echo $product['price']; ?></td>
                                    <td class="total"><?php echo $price; ?></td>
                                    <td class="text-center">
                                        <form name="remove-product" action="" method="get">
                                            <button name="<?php echo $count; ?>" class="remove-product" type="button" value="<?php echo $cart_item["id"]; ?>" class="close" aria-label="Close">
                                                X
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                                $count = $count + 1;
                            }
                            ?>
                            <tr class="product-cart">
                                <td class="cart-checkbox"><label><input class="check-all" type="checkbox"></label></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td id="total">0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn-group btns-cart">
                    <a href="/"><button type="button" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i>Continue Shopping</button></a>
                    <button type="button" class="btn btn-primary update-cart">Update Cart</button>
                    <button type="button" class="btn btn-primary checkout">Checkout <i class="fa fa-arrow-circle-right"></i></button>
                </div>

            </div>
        </div>
        <!-- End Cart -->
    </div>
</div>