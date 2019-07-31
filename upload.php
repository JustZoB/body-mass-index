<?php
declare (strict_types=1);
require_once 'functions.php';

$filePath = uploadFile($_FILES['uploadedFile']['name'], $_FILES['uploadedFile']['tmp_name']);

$resultArray = peopleToArray(readPeople($filePath), true);
arrayToCsv($resultArray);

header("Location: exerciseSeven.php");