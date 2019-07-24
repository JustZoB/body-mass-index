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
    <?php
    require_once 'functions.php';
    
    if ((int)$_POST['mass'] && (int)$_POST['height'] && (int)$_POST['chest']) {
        $result = fopen("result.csv", "w+");
        $guysCount = 0;
        $resultArray = addTableHeaders($indexsArray, $guysCount);
        $guysCount++;

        $resultArray[$guysCount]['mass'] = (int) htmlspecialchars($_POST['mass']);
        $resultArray[$guysCount]['height'] = (int) htmlspecialchars($_POST['height']);
        $resultArray[$guysCount]['chest'] = (int) htmlspecialchars($_POST['chest']);

        foreach ($indexsArray as $indexBodyMass) {
            $resultArray = writeIndexToResultArray($indexBodyMass['name'], 
            $indexBodyMass['formula']((int) $_POST['height'], (int) $_POST['mass'], (int) $_POST['chest']), 
            (int) $_POST['mass'], $resultArray, $guysCount);
        }
        foreach ($resultArray as $resultArrayString) {
            fputcsv($result, $resultArrayString);
        }
        fclose($result);

        echo '<p>Вес ' . htmlspecialchars($_POST['mass']) . '</p>';
        echo '<p>Рост ' . htmlspecialchars($_POST['height']) . '</p>';
        echo '<p>Окружнось грудной клетки ' . htmlspecialchars($_POST['chest']) . '</p>';
    } else {
        echo '<br /><p>Введите корректные данные</p>';
    }
    ?>
   </body>
</html>