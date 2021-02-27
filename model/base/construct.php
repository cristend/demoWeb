<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/db.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/base/CRUD.php";

$model = new Model();
$conn = $model->get_conn();
