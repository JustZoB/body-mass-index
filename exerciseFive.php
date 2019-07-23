<?php
    declare(strict_types = 1);
    require_once 'functions.php';

    $guys = [];

    $result = fopen("result.csv", "w+");
    $guyscount = 0;
    $resultArray = addHeaders();

    $err = false;
    if (count($argv) > 1) {
        for ($i = 1; $i < count($argv); $i++) {
            if ((float)$argv[$i] == 0) {
                echo "Введите ненулевое число";
                $err = true;
            }
        }
        if (!$err) {
            $guys = readARGV($argv);

            if ((count($argv) - 1) % TABLE_COL == 1) {
                echo "Введите свои рост и окружность грудной клетки.\n";
                unset($guys[$row]);
            } elseif ((count($argv) - 1) % TABLE_COL == 2) {
                echo "Введите свою окружность грудной клетки.\n";
                unset($guys[$row]);
            }
        }
    } else {
        $guys = readGuys();
    }

    foreach ($guys as $guy) {
        $resultArray[$guyscount]['mass'] = $mass = $guy['mass'];
        $resultArray[$guyscount]['height'] = $height = $guy['height'];
        $resultArray[$guyscount]['chest'] = $chest = $guy['chest'];

        foreach ($indexsArray as $name) {
            createIndexCSV($name, round($name((int)$height, (int)$mass, (int)$chest), 2), (int)$mass);
        }

        $guyscount++;
    }
    
    foreach ($resultArray as $resultArrayString) {
        fputcsv($result, $resultArrayString);
    }
    fclose($result);
?>