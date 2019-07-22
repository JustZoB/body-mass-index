<?php
    const TABLE_COL = 3;

    function readFile() : array 
    {
        /*$guys = [];
        $row = 0;
        $file = [];
        if (($file = fopen('guys.csv', 'r')) !== FALSE) {
            while (($line = fgetcsv($file, 1000, ',')) !== FALSE) {  
                for ($i = 0; $i < TABLE_COL; $i++) {
                    $guys[$row][$i] = $line[$i];
                    // mass, height, chest
                }
                $row++;
            }
            fclose($file);
        }

        return $guys;*/
    }

    function createIndex(string $name, float $index, int $mass)
    {
        global $list;
        if ($name == 'IMT') {
            $norm = normIMT($index);
        } elseif ($name == 'Davenport') {
            $norm = normDavenport($index);
        } else {
            $norm = norm($index, $mass);
        }
        echo "Index $name: $index, Norm $name: $norm \n";
    }
    
    function norm(float $index, int $mass) : string
    {
        if ((($index - 15) > $mass) || (($index + 15) < $mass)) {
            return '-';
        } else {
            return '+';
        }
    }

    function normIMT(float $index) : string
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

    function normDavenport(float $index) : string
    {
        if (($index > 3) or ($index < 1)) {
            return '-';
        } else {
            return '+';
        }
    }
?>