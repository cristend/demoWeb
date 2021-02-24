<?php
include "$_SERVER[DOCUMENT_ROOT]/model/table/users.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/construct.php";


function login($conn, $user_data)
{
    $user_model = new Users($conn);
    $login_status = $user_model->login($user_data);
    if ($login_status['msg'] == "success") {
        return true;
    } 
    return false;
}

if (isset($_POST)) {
    $user_data = [
        "email" => $_POST["email"],
        "pass" => $_POST["password"],
    ];

    $login_success = login($conn, $user_data);

    if (!$login_success) {
        echo json_encode([
            'errors' => "error",
            'location' => ""
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'location' => '/',
            'errors' => ""
        ]);
    }
}
