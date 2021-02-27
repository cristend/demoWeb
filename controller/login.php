<?php
session_start();
include "$_SERVER[DOCUMENT_ROOT]/model/table/users.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/construct.php";


function login($conn, $user_data)
{
    $user_model = new Users($conn);
    $login_status = $user_model->login($user_data);
    if ($login_status['msg'] == "success") {
        return $login_status['data'];
    }
    return false;
}

if (isset($_POST)) {
    $user_data = [
        "email" => $_POST["email"],
        "pass" => $_POST["password"],
    ];
    $url = $_POST["submit"];
    $params = explode("*", $url);
    if (count($params) > 1) {
        $url = "?" . $params[1];
    } else {
        $url = "";
    }

    $login_success = login($conn, $user_data);

    if (!$login_success) {
        echo json_encode([
            'errors' => "error",
            'location' => ""
        ]);
    } else {
        $_SESSION['user'] = $login_success['id'];
        header('Content-Type: application/json');
        echo json_encode([
            'location' => '/' . $url,
            'errors' => ""
        ]);
    }
}
