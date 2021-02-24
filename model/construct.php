<?php
include_once "$_SERVER[DOCUMENT_ROOT]/model/db.php";
include_once "$_SERVER[DOCUMENT_ROOT]/model/CRUD.php";

$model = new Model();
$conn = $model->get_conn();
