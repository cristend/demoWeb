<?php
session_start();
include_once "$_SERVER[DOCUMENT_ROOT]/view/home_header.php";
include_once "$_SERVER[DOCUMENT_ROOT]/view/home_navigation.php";
include_once "$_SERVER[DOCUMENT_ROOT]/controller/user_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/help/etc.php";
$current_url = "";
if (isset($_SESSION['user'])) {
    $id = $_SESSION['user'];
    $user = get_user($id, $user_model);
    if ($user) {
        echo '<li class="nav-item"><a id="user-icon" href="#"><img src="/static/images/profile.svg"/></li>
          <li class="nav-item">
            <a class="nav-link" href="#">' . $user['name'] . '</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/controller/logout.php">Logout</a>
          </li>
          <li class="nav-item">
            <a id="cart-icon" class="nav-link" href="">
                <img src="/static/images/shopping-cart.png"/>
                <div id="cart-item"><span></span></div>
            </a>
          </li>
        </ul>
    </div>
</div>
</nav>';
    } else {
        echo '</ul>
        </div>
    </div>
    </nav>';
    }
} else {
    if ($_GET) {
        $current_url = get_params_url($_GET);
    }
    echo '<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
          <li class="nav-item">
            <a class="nav-link" href="login.php' . $current_url . '">Login</a>
          </li>
        </ul>
    </div>
</div>
</nav>';
}
if (isset($_GET['route'])) {
    $route = $_GET['route'];
    if ($route == 'product') {
        include "$_SERVER[DOCUMENT_ROOT]/product/product.php";
    }
    $current_url = get_params_url($_GET);
} else {
    include_once "$_SERVER[DOCUMENT_ROOT]/controller/product_model.php";
?>
    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <h1 class="my-4">Flechazo</h1>
                <div class="list-group">
                    <a href="#" class="list-group-item">Category 1</a>
                    <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a>
                </div>

            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block img-fluid" src="/static/images/slider1.jpeg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="/static/images/slider2.png" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="/static/images/slider3.jpeg" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                <div class="row">
                    <?php
                    $current_page = 1;
                    if (isset($_GET['page'])) {
                        $current_page = $_GET['page'];
                    }
                    $products = paging($product_model, $current_page);
                    $pages = get_page($product_model);
                    // $products = get_products($product_model);
                    if (is_array($products)) {
                        foreach ($products as $product) {
                            $id = $product['id'];
                            $image = $product['image'];
                            $href = "/?route=product&&id=" . $id;
                            $title = $product['title'];
                            $price = $product['price'];
                            $detail = $product['detail'];
                            echo '<div class="col-lg-4 col-md-6 mb-4">
                            <div class="card product">
                                <a href="' . $href . '"><img class="card-img-top" src="' . $image . '" alt=""></a>
                                <div class="card-body">
                                    <div class="card-title">
                                        <a href="' . $href . '">' . $title . '</a>
                                    </div>
                                    <h5>$' . $price . '</h5>
                                    <p class="card-text">' . $detail . '</p>
                                </div>
                            </div>
                        </div>';
                        }
                    }
                    ?>

                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <?php for ($page = 1; $page <= $pages; $page++) {
                            if ($page == $current_page) {
                                echo '<li class="page-item active"><a class="page-link" href="/?page=' . $page . '">' . $page . '</a></li>';
                                continue;
                            }
                            echo '<li class="page-item"><a class="page-link" href="/?page=' . $page . '">' . $page . '</a></li>';
                        } ?>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
<?php
}

// include_once "$_SERVER[DOCUMENT_ROOT]/view/home_main.html";
include_once "$_SERVER[DOCUMENT_ROOT]/view/home_footer.html";
// }
if (isset($_GET['route'])) {
    // 
}
