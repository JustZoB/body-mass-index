<?php
declare (strict_types=1);
require_once 'functions.php';

$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
$fileName = $_FILES['uploadedFile']['name'];

$dest_path = './uploaded_files/' . $fileName;
move_uploaded_file($fileTmpPath, $dest_path);

$resultArray = addHeaders();
$resultArray = peopleToArray(readPeople($dest_path), $resultArray);
arrayToCsv($resultArray);

header("Location: exerciseSeven.php");