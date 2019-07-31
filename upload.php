<?php
declare (strict_types=1);
require_once 'functions.php';
if (isset($_FILES['uploadedFile'])) {
    $filePath = uploadFile($_FILES['uploadedFile']['name'], $_FILES['uploadedFile']['tmp_name']);
    arrayToCsv(peopleToArray(readPeople($filePath), true));
}

header("Location: exerciseSeven.php");
