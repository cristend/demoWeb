<?php
function add_and_condition(string $condition, array $conditions)
{
    foreach ($conditions as $add_condition) {
        $condition = $condition . $add_condition . " && ";
    }
    $condition = rtrim($condition, " && ");
    return $condition;
}
function add_or_condition(string $condition, array $conditions)
{
    foreach ($conditions as $add_condition) {
        $condition = $condition . $add_condition . " || ";
    }
    $condition = rtrim($condition, " || ");
    return $condition;
}
