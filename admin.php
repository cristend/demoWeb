<?php
include ('model/table/tables.php');
include ('model/construct.php');

foreach ($table_list as $table_name=>$table) {
    $query = "SELECT 1 FROM " . $table_name . " LIMIT 1";
    $table_exist = $db->execute($query);
    if (!$table_exist){
        $db->execute($table);
        $db->commit();
    }
}