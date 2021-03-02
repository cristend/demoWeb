<?php
if (isset($_SESSION["user"])) {
    include_once "$_SERVER[DOCUMENT_ROOT]/model/user_model.php";
    $user = get_user($_SESSION["user"], $user_model);
?>
    <link rel="stylesheet" ,="" href="/static/css/cart.css">
    <div class="col-md-12 profile-content-main" style="display: flex !important;">
        <div class="col-md-3">
            <div class="portlet light profile-sidebar-portlet bordered">
                <div class="profile-userpic">
                    <img src="/static/images/user-profile.png" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> <?php echo $user["name"]; ?> </div>
                    <div><a href="?route=user_edit">Edit</a></div>
                </div>
                <div class="profile-usermenu">
                    <ul class="nav profile-nav">
                        <li>
                            <a href="?route=user_history">
                                <i></i> Order </a>
                        </li>
                        <li>
                            <a href="?route=user_profile">
                                <i></i> Profile </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php
} else {
    header("Location: /404.php");
}
