<?php
define("ERROR_TYPE_EXIST", "object_exist");

function return_error($data, $error, $type = "exception", $msg = "")
{
    $return_value = [
        "data" => $data,
        "error" => $error,
        "error_type" => $type,
        "msg" => $msg
    ];
    return $return_value;
}
function return_success($data = "", $error = "", $type = "", $msg = "success")
{
    $return_value = [
        "data" => $data,
        "error" => $error,
        "error_type" => $type,
        "msg" => $msg
    ];
    return $return_value;
}
function return_fail($data = "", $error = "", $type = "", $msg = "fail")
{
    $return_value = [
        "data" => $data,
        "error" => $error,
        "error_type" => $type,
        "msg" => $msg
    ];
    return $return_value;
}
function clean_array(array $array)
{
    $clean_array = [];
    foreach ($array as $key => $value) {
        if ($value) {
            $clean_array[$key] = $value;
        }
    }
    return $clean_array;
}
function logError($error)
{
    $date = new DateTime();
    $date = $date->format("y:m:d h:i:s");
    $error = $date . "\n" . $error . "\n";
    return error_log($error, 3, "errors.log");
}
function strfy($array)
{
    return implode(', ', array_map(
        function ($v, $k) {
            if (is_array($v)) {
                return $k . '[]=' . implode('&' . $k . '[]=', $v);
            } else {
                return $k . '=' . $v;
            }
        },
        $array,
        array_keys($array)
    ));
}
