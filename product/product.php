<?php
include_once "$_SERVER[DOCUMENT_ROOT]/view/home_header.html";
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
    })
</script>
<?php
include_once "$_SERVER[DOCUMENT_ROOT]/view/home_navigation.html";
include_once "$_SERVER[DOCUMENT_ROOT]/controller/product.php";
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
                    <div class="section">
                        <?php
                        $variables = $product_detail['variable'];
                        if (is_array($variables)) {
                            foreach ($variables as $variant => $values) {
                                echo '<h6 class="title-attr" style="margin-top:15px;"><small>' . $variant . '</small></h6>';
                                foreach ($values as $value) {
                                    echo '<div class="attr" style="width:25px;">' . $value . '</div>';
                                }
                            }
                        }
                        ?>
                        <div class="section" style="padding-bottom:20px;">
                            <h6 class="title-attr"><small>Quantity</small></h6>
                            <div>
                                <div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
                                <input value="1" />
                                <div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de compra -->
                    <div class="section" style="padding-bottom:20px;">
                        <button class="btn btn-success"><span style="margin-right:20px" class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>Add to cart</button>
                    </div>
                </div>

                <div class="col-xs-9">
                    <ul class="menu-items">
                        <li class="active">Detail</li>
                    </ul>
                    <div style="width:100%;border-top:1px solid silver">
                        <p style="padding:15px;">
                            <small><?php echo $product_detail['detail']; ?></small>
                        </p>
                        <!-- <small>
                            <ul>
                                <li>Super AMOLED capacitive touchscreen display with 16M colors</li>
                                <li>Available on GSM, AT T, T-Mobile and other carriers</li>
                                <li>Compatible with GSM 850 / 900 / 1800; HSDPA 850 / 1900 / 2100 LTE; 700 MHz Class 17 / 1700 / 2100 networks</li>
                                <li>MicroUSB and USB connectivity</li>
                                <li>Interfaces with Wi-Fi 802.11 a/b/g/n/ac, dual band and Bluetooth</li>
                                <li>Wi-Fi hotspot to keep other devices online when a connection is not available</li>
                                <li>SMS, MMS, email, Push Mail, IM and RSS messaging</li>
                                <li>Front-facing camera features autofocus, an LED flash, dual video call capability and a sharp 4128 x 3096 pixel picture</li>
                                <li>Features 16 GB memory and 2 GB RAM</li>
                                <li>Upgradeable Jelly Bean v4.2.2 to Jelly Bean v4.3 Android OS</li>
                                <li>17 hours of talk time, 350 hours standby time on one charge</li>
                                <li>Available in white or black</li>
                                <li>Model I337</li>
                                <li>Package includes phone, charger, battery and user manual</li>
                                <li>Phone is 5.38 inches high x 2.75 inches wide x 0.13 inches deep and weighs a mere 4.59 oz </li>
                            </ul>
                        </small> -->
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