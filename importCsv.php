<?php
declare (strict_types=1);
require_once 'functions.php';

$filePath = dirname(__FILE__) . '/uploaded_files/';
if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $extension_file = mb_strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    $full_unique_name = $filePath . uniqid('file_', true).'.'.$extension_file;
    move_uploaded_file($_FILES['file']['tmp_name'], $full_unique_name);
    $filePath = uploadFile($_FILES['file']['name'], $_FILES['file']['tmp_name']);
    $array = getResult(readCsv($filePath), true);
    writeCsv($array);
    sqlQueryInsert($array);
    echo json_encode($array);
}
