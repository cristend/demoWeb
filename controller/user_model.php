<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/users.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/construct.php";

$user_model = new Users($conn);

function get_user($id, Users $model)
{
    $user_status = $model->get_user($id);
    if ($user_status['msg'] == 'success') {
        $user = $user_status['data'];
        return $user;
    }
    return "";
}
