<?php
    $row = 0;
    if (($guys = fopen("guys.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($guys, 1000, ",")) !== FALSE) {
            $row++;
            for ($c=0; $c < 2; $c++) {
                if (!$c) $mass = $data[$c]; else $height = $data[$c];   
            }
            $index = round($mass / ($height ** 2), 2);
            echo "Id: $row, Масса: $mass, Рост: $height, Индекс массы тела: $index. \n";
        }
    fclose($guys);
    }
?>