<?php
require_once 'functions.php';

if (isset($_POST['mass']) && isset($_POST['height']) && isset($_POST['chest'])) {
    $result = fopen("result.csv", "w+");
    
    $resultArray = addTableHeaders($indexsArray, 0);
    $guysCount = 1;

    $resultArray[$guysCount]['mass'] = (int) $_POST['mass'];
    $resultArray[$guysCount]['height'] = (int) $_POST['height'];
    $resultArray[$guysCount]['chest'] = (int) $_POST['chest'];

    foreach ($indexsArray as $indexBodyMass) {
        $resultArray = writeIndexToResultArray($indexBodyMass['name'], 
        $indexBodyMass['formula']((int) $_POST['height'], (int) $_POST['mass'], (int) $_POST['chest']), 
        (int) $_POST['mass'], $resultArray, $guysCount);
    }
    foreach ($resultArray as $resultArrayString) {
        fputcsv($result, $resultArrayString);
    }
    fclose($result);
}
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Индекс массы тела</title>
   </head>
   <body>
   <form action="exerciseSix.php" method="post">
        <p>Ваш вес: <input type="text" name="mass" /></p>
        <p>Ваш рост: <input type="text" name="height" /></p>
        <p>Ваша окружнось грудной клетки: <input type="text" name="chest" /></p>
        <p><input type="submit" /></p>
    </form>
    <?php if (isset($_POST['mass']) && isset($_POST['height']) && isset($_POST['chest'])) :  ?>
     <?= '<p>Вес ' . htmlspecialchars($_POST['mass']) . '</p>' ?>
     <?= '<p>Рост ' . htmlspecialchars($_POST['height']) . '</p>' ?>
     <?= '<p>Окружнось грудной клетки ' . htmlspecialchars($_POST['chest']) . '</p>' ?>
     <?php endif ?>
   </body>
</html>