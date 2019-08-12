<?php
declare (strict_types=1);
require_once 'functions.php';
require_once 'sqlFunctions.php';

$result = getDatabase('files');
if ($result) {
    array_unshift($result, array_keys(reset($result)));
    echo json_encode($result);
}
