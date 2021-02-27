<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/user_model.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/cart_model.php";


function register($conn, $user_data, $user_model, $cart_model)
{
    $errors = [];
    $user_status = add_user($user_data, $user_model);
    if ($user_status['msg'] == "success") {
        $user_id = $user_status['data'];
        $cart_id = add_cart($cart_model, $user_id);
        return true;
    } else {
        array_push($errors, $user_status["error"]);
    }
    return $errors;
}

if (isset($_POST)) {
    $user_data = [
        "name" => $_POST["name"],
        "email" => $_POST["email"],
        "pass" => $_POST["password"],
        "bio" => $_POST["bio"],
        "sex" => $_POST["sex"],
        "birth" => $_POST["birthday"]
    ];

    $register_success = register($conn, $user_data, $user_model, $cart_model);
    if ($register_success === true) {
        header('Content-Type: application/json');
        echo json_encode([
            'location' => '/login.php',
            'errors' => ""
        ]);
    } else {
        if ($register_success) {
            echo json_encode([
                'errors' => $register_success,
                'location' => ""
            ]);
        }
    }
}
