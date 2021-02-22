<?php
function logError($error)
{
    $date = new DateTime();
    $date = $date->format("y:m:d h:i:s");
    $error = $date . "\n" . $error . "\n";
    return error_log($error, 3, "errors.log");
}
