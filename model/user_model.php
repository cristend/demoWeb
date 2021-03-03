<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/table/users.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/construct.php";

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

function edit_user($user_id, Users $model, array $array)
{
    $data = $model->construct_user();
    foreach ($array as $key => $value) {
        $data[$key] = $value;
    }
    $model->edit($user_id, $data);
}

function add_user($data, Users $model)
{
    $user_status = $model->add($data);
    if ($user_status['msg'] == 'success') {
        $user_id = $user_status['data'];
        return return_success($user_id);
    }
    return $user_status;
}

function update_user($user_id, $data, Users $model)
{
    $model->edit($user_id, $data);
}
