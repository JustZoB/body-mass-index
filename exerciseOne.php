<?php
    declare(strict_type = 1);
    const TABLE_COL = 3;
    $row = 0;
    $guys = [];
    $file = [];
    if (($file = fopen('guys.csv', 'r')) !== FALSE) {
        while (($line = fgetcsv($file, 1000, ',')) !== FALSE) {  
            for ($i = 0; $i < TABLE_COL; $i++) {
                $guys[$row][$i] = $line[$i];
                // mass, height, chest
            }
            $row++;
        }
    }
    fclose($file);

    foreach ($guys as $guy) {
        $mass = $guy[0];
        $height = $guy[1];
        $chest = $guy[2];
        echo "Mass: $mass, Height: $height, Chest circumference: $chest \n";
        createIndex('IMT', round($mass * 10000 / ($height ** 2) , 2), $mass);
        createIndex('Brok', round($height - 100, 2), $mass);
        createIndex('Breytman', round($height * 0.7 - 50, 2), $mass);
        createIndex('Berngard', round($chest * $height / 240, 2), $mass);
        createIndex('Davenport', round($mass * 1000 / (($height ** 2)), 2), $mass);
        createIndex('Noorden', round($height * 0.42, 2), $mass);
        createIndex('Tatony', round($height - 100 - ($height - 100) / 20, 2), $mass);
    }
    
    function createIndex($name, $index, $mass) 
    {
        if ($name == 'IMT') {
            $norm = normIMT($index);
        } elseif ($name == 'Davenport') {
            $norm = normDavenport($index);
        } else {
            $norm = norm($index, $mass);
        }
        echo "Index $name: $index, Norm $name: $norm \n";
    }
    
    function norm($index, $mass) {
        if ((($index - 15) > $mass) || (($index + 15) < $mass)) {
            return '-';
        } else {
            return '+';
        }
    }

    function normIMT($index)
    {
        if ($index <= 16) {
            return 'Выраженный дефицит';
        } elseif ($index <= 18.5) {
            return 'Дефицит';
        } elseif ($index <= 25) {
            return 'Норма';
        } elseif ($index <= 30) {
            return 'Избыточная';
        } elseif ($index <= 35) {
            return 'Ожирение';
        } elseif ($index <= 40) {
            return 'Резкое ожирение';
        } elseif ($index > 40) {
            return 'Очень резкое ожирение';
        }
    }

    function normDavenport($index) 
    {
        if (($index > 3) or ($index < 1)) {
            return '-';
        } else {
            return '+';
        }
    }
?>

