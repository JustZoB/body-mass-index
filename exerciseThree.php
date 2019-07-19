<?php
    $row = 0;
    if (($guys = fopen("guys.csv", "r")) !== FALSE) {
    $result = fopen("result.csv", "w+");
    $headers = array('Id', 'Mass', 'Height', 'IndexMass');
    fputcsv($result, $headers);
        while (($data = fgetcsv($guys, 1000, ",")) !== FALSE) {
            $row++;
            for ($c=0; $c < 2; $c++) {
                if (!$c) $mass = $data[$c]; else $height = $data[$c];   
            }
            $index = round($mass / ($height ** 2), 2);
            $list = array($row,$mass,$height,$index);
            fputcsv($result, $list);
        }
    fclose($guys);
    fclose($result);
    }
?>