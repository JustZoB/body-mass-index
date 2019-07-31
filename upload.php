<?php
declare (strict_types=1);
session_start();
require_once 'functions.php';

$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
$fileName = $_FILES['uploadedFile']['name'];

$dest_path = './uploaded_files/' . $fileName;
move_uploaded_file($fileTmpPath, $dest_path);

$resultArray = addHeaders();
$resultArray = peopleToArray(readPeople($dest_path), $resultArray);
arrayToCsv($resultArray);

$_SESSION['message'] = 'Result in result.csv';
header("Location: exerciseSeven.php");