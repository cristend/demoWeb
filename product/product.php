<?php
include_once "$_SERVER[DOCUMENT_ROOT]/view/home_header.php";
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" , href="../static/css/product.css">
<script>
    $(function() {
        $("ul.menu-items > li").on("click", function() {
            $("ul.menu-items > li").removeClass("active");
            $(this).addClass("active");
        })

        $(".attr,.attr2").on("click", function() {
            var clase = $(this).attr("class");

            $("." + clase).removeClass("active");
            $(this).addClass("active");
        })

        $(".btn-minus").on("click", function() {
            var now = $(".section > div > input").val();
            if ($.isNumeric(now)) {
                if (parseInt(now) - 1 > 0) {
                    now--;
                }
                $(".section > div > input").val(now);
            } else {
                $(".section > div > input").val("1");
            }
        })

        $(".btn-plus").on("click", function() {
            var now = $(".section > div > input").val();
            if ($.isNumeric(now)) {
                $(".section > div > input").val(parseInt(now) + 1);
            } else {
                $(".section > div > input").val("1");
            }
        })
        $('form[name=cart]').bind('submit', function() {
            $.ajax({
                type: 'post',
                url: '/controller/cart.php',
                data: $('form').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.location) {
                        window.location.href = response.location;
                    }
                    if (response.data) {
                        var cart_item = document.getElementById("cart-item");
                        var cart_item_number = document.getElementById("item-number");
                        cart_item_number.innerHTML = response.data;
                        if (response.data) {
                            $(cart_item).show();
                        }
                        alert('Add success!');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
            return false;
        })
    })
</script>
<?php
include_once "$_SERVER[DOCUMENT_ROOT]/view/home_navigation.php";
include_once "$_SERVER[DOCUMENT_ROOT]/controller/product_model.php";
if (isset($_GET)) {
    $id = $_GET['id'];
    $product_detail = get_product($id, $product_model);
    if ($product_detail) {
?>
        <div class="container">
            <div class="row">
                <div class="col-xs-4 item-photo">
                    <img style="max-width:100%;" src="<?php echo $product_detail['image']; ?>" />
                </div>
                <div class="col-xs-5" style="border:0px solid gray">
                    <!-- Datos del vendedor y titulo del producto -->
                    <h3><?php echo $product_detail['title']; ?></h3>

                    <!-- Precios -->
                    <h6 class="title-price"><small>Price</small></h6>
                    <h3 style="margin-top:0px;"><?php echo $product_detail['price']; ?></h3>

                    <!-- Detalles especificos del producto -->
                    <form name="cart" action="" method="post">
                        <div class="section">
                            <?php
                            $variables = $product_detail['variable'];
                            if (is_array($variables)) {
                                foreach ($variables as $variant => $values) {
                                    echo '
                                    <label for="' . $variant . '">' . $variant . '
                                    <select required name="' . $variant . '" id="' . $variant . '">';
                                    foreach ($values as $value) {
                                        echo '<option value="' . $value . '">' . $value . '</option>';
                                    }
                                    echo '</select></label>';
                                }
                            }
                            ?>
                            <div class="section" style="padding-bottom:20px;">
                                <h6 class="title-attr">Quantity</h6>
                                <div>
                                    <div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
                                    <input name="quantity" value="1" />
                                    <div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
                                </div>
                            </div>
                            <input name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" type="hidden" />
                        </div>

                        <!-- Botones de compra -->
                        <div class="section" style="padding-bottom:20px;">
                            <input name="submit" type="submit" value="Add to cart" class="btn btn-success btn-success-short" />
                            <input name="submit" type="submit" value="Purchase" class="btn btn-warning" />
                            <!-- </form> -->

                        </div>
                    </form>
                </div>

                <div class="col-xs-9">
                    <ul class="menu-items">
                        <li class="active">Detail</li>
                    </ul>
                    <div style="width:100%;border-top:1px solid silver">
                        <p style="padding:15px;">
                            <small><?php echo $product_detail['detail']; ?></small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "Fail to get product detail";
    }
}
?>
<!-- <?php
        include_once "$_SERVER[DOCUMENT_ROOT]/view/home_footer.html";
        ?> -->