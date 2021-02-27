<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/user_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_item_model.php";
$uri = $_SERVER["REQUEST_URI"];
$current_uri = ltrim($uri, "/");
$login_controller = '/user/login.php';
if (isset($_SESSION['user'])) {
    $id = $_SESSION['user'];
    $user = get_user($id, $user_model);
    $count = get_number_item($cart_item_model);
}
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a id="flechazo-logo" class="navbar-brand" href="/"><img src="/static/images/logo.png" alt="Flechazo Shop"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item"><a id="user-icon" href="#"><img src="/static/images/profile.svg" /></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo $user['name']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/controller/logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a id="cart-icon" class="nav-link" href="?route=cart">
                            <img src="/static/images/shopping-cart.png" />
                            <?php if ($count) {
                                echo '<div id="cart-item" style="display:initial !important"><span id="item-number">' . $count . '</span></div>';
                            } else {
                                echo '<div id="cart-item"><span id="item-number"></span></div>';
                            } ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>