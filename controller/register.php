<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/users.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/construct.php";


function register($conn, $user_data)
{
    $user_model = new Users($conn);
    $errors = [];
    $create_user_status = $user_model->add($user_data);
    if ($create_user_status['msg'] == "success") {
        return true;
    } else {
        array_push($errors, $create_user_status["error"]);
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

    $register_success = register($conn, $user_data);
    if ($register_success === true) {
        header('Content-Type: application/json');
        echo json_encode([
            'location' => '/login.php',
            'errors' => ""
        ]);
    } else {
        if ($register_success) {
            echo json_encode([
                'errors' => $register_errors,
                'location' => ""
            ]);
        }
    }
}
// header('Location: /');
