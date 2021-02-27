<link rel="stylesheet" , href="/static/css/cart.css">
<script>
    $(function() {
        $(".btn-minus").on("click", function() {
            var input = $(".item-quantity > div > input[name=quantity]");
            var now = input.val();
            if ($.isNumeric(now)) {
                if (parseInt(now) - 1 > 0) {
                    now--;
                }
                input.val(now);
            } else {
                input.val("1");
            }
        });

        $(".btn-plus").on("click", function() {
            var input = $(".item-quantity > div > input[name=quantity]");
            var now = input.val();
            if ($.isNumeric(now)) {
                input.val(parseInt(now) + 1);
            } else {
                input.val("1");
            }
        });
    });
</script>
<div class="container bootdey">
    <div class="row bootstrap snippets">
        <div class="clearfix visible-sm"></div>

        <!-- Cart -->
        <div class="col-lg-9 col-md-9 col-sm-12">
            <div class="col-lg-12 col-sm-12">
                <span class="title">SHOPPING CART</span>
            </div>
            <div class="col-lg-12 col-sm-12 hero-feature">
                <div class="table-responsive">
                    <table class="table table-bordered tbl-cart">
                        <thead>
                            <tr>
                                <td class="hidden-xs">Image</td>
                                <td>Product Name</td>
                                <td>Size</td>
                                <td>Color</td>
                                <td class="td-qty">Quantity</td>
                                <td>Unit Price</td>
                                <td>Sub Total</td>
                                <td>Remove</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="hidden-xs">
                                    <a href="#">
                                        <img src="https://via.placeholder.com/200x200/" alt="Age Of Wisdom Tan Graphic Tee" title="" width="47" height="47">
                                    </a>
                                </td>
                                <td><a href="#">Age Of Wisdom Tan Graphic Tee</a>
                                </td>
                                <td>
                                    <select name="">
                                        <option value="" selected="selected">S</option>
                                        <option value="">M</option>
                                    </select>
                                </td>
                                <td>-</td>
                                <td class="item-quantity">
                                    <div class="input-group bootstrap-touchspin">
                                        <span class="input-group-btn">
                                            <button class="btn btn-minus btn-default bootstrap-touchspin-down" type="button">-</button>
                                        </span>
                                        <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                                        <input type="text" name="quantity" value="2" class="input-qty form-control text-center" style="display: block;">
                                        <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
                                        <span class="input-group-btn">
                                            <button class="btn btn-plus btn-default bootstrap-touchspin-up" type="button">+</button>
                                        </span>
                                    </div>
                                </td>
                                <td class="price">$ 122.21</td>
                                <td>$ 122.21</td>
                                <td class="text-center">
                                    <a href="#" class="remove_cart" rel="2">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="hidden-xs">
                                    <a href="#">
                                        <img src="https://via.placeholder.com/200x200/" alt="Adidas Men Red Printed T-shirt" title="" width="47" height="47">
                                    </a>
                                </td>
                                <td><a href="#">Adidas Men Red Printed T-shirt</a>
                                </td>
                                <td>
                                    <select name="">
                                        <option value="">S</option>
                                        <option value="" selected="selected">M</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="">
                                        <option value="" selected="selected">Red</option>
                                        <option value="">Blue</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span><input type="text" name="" value="2" class="input-qty form-control text-center" style="display: block;"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span></div>
                                </td>
                                <td class="price">$ 20.63</td>
                                <td>$ 41.26</td>
                                <td class="text-center">
                                    <a href="#" class="remove_cart" rel="1">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" align="right">Total</td>
                                <td class="total" colspan="2"><b>$ 163.47</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn-group btns-cart">
                    <button type="button" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Continue Shopping</button>
                    <button type="button" class="btn btn-primary">Update Cart</button>
                    <button type="button" class="btn btn-primary">Checkout <i class="fa fa-arrow-circle-right"></i></button>
                </div>

            </div>
        </div>
        <!-- End Cart -->
    </div>
</div>