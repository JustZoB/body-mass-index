<?php
declare (strict_types=1);
require_once 'functions.php';

$result = sqlQueryGetTable();
$heads = array_keys($result[0]);
array_unshift($result, $heads);
echo json_encode($result);