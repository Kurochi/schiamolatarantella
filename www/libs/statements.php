<?php
function BindParamsArray($statement, &$types, $params)
{
    array_unshift($params, $types);
    $reflectionClass = new ReflectionClass('mysqli_stmt');
    $bindParamMethod = $reflectionClass->getMethod("bind_param");
    $bindParamMethod->invokeArgs($statement, $params);
}