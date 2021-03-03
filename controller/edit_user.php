<?php
if (isset($_POST)) {
    session_start();
    if (isset($_SESSION["user"])) {
        include_once "$_SERVER[DOCUMENT_ROOT]/model/user_model.php";
        $user_id = $_SESSION["user"];
        edit_user($user_id, $user_model, $_POST);
        echo json_encode([
            "location" => "?route=user_profile"
        ]);
    }
} else {
    echo json_encode(["location" => ""]);
}
