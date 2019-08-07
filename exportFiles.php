<?php
declare (strict_types=1);
require_once 'functions.php';
require_once 'sqlFunctions.php';

$result = sqlExport('files');
if ($result) {
    $columnName = array_keys(reset($result));
    array_unshift($result, $columnName);
    echo json_encode($result);
}
