<?php
include('model/table/tables.php');
include('model/base/construct.php');
include_once('model/base/CRUD.php');

$crud = new CRUD($conn);
foreach ($table_list as $table_name => $table) {
    $query = "SELECT 1 FROM " . $table_name . " LIMIT 1";
    $table_exist = $crud->execute($query);
    if (!$table_exist) {
        $crud->execute($table);
    }
}
