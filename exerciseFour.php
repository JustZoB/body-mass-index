<?php
    declare(strict_types = 1);
    const TABLE_COL = 3;
    $row = 0;
    $guys = [];
    $file = [];
    $err = false;
    $result = fopen("result.csv", "w+");
    $headers = ['Mass', 'Height', 'Chest', 'IMT', 'IMT norm', 'Broke', 'Broke norm', 'Breytman', 'Breytman norm', 
    'Berngard', 'Berngard norm', 'Davenport', 'Davenport norm', 'Noorden', 'Noorden norm', 'Tatonya', 'Tatonya norm'];
    fputcsv($result, $headers);

    for ($i = 1; $i < count($argv); $i++) {
        if ((float)$argv[$i] == 0) {
            echo "Введите ненулевое число";
            $err = true;
        }
    }
    if (!$err) {
        for ($i = 1; $i < count($argv); $i++) {
            $guys[$row][] = $argv[$i];
            if ($i % TABLE_COL == 0) {
                $row++;
            }
        }
    
        if (count($argv) == 1) {
            echo "Введите свои массу, рост и окружность грудной клетки.";
        } elseif ((count($argv) - 1) % TABLE_COL == 1) {
            echo "Введите свои рост и окружность грудной клетки.";
            unset($guys[$row]);
        } elseif ((count($argv) - 1) % TABLE_COL == 2) {
            echo "Введите свою окружность грудной клетки.";
            unset($guys[$row]);
        } 

        foreach ($guys as $guy) {
            $mass = $guy[0];
            $height = $guy[1];
            $chest = $guy[2];
    
            $list = [];
            $list[] = $mass;
            $list[] = $height;
            $list[] = $chest;
    
            createIndex('IMT', round($mass * 10000 / ($height ** 2) , 2), (int)$mass);
            createIndex('Brok', round($height - 100, 2),(int)$mass);
            createIndex('Breytman', round($height * 0.7 - 50, 2), (int)$mass);
            createIndex('Berngard', round($chest * $height / 240, 2), (int)$mass);
            createIndex('Davenport', round($mass * 1000 / (($height ** 2)), 2), (int)$mass);
            createIndex('Noorden', round($height * 0.42, 2), (int)$mass);
            createIndex('Tatony', round($height - 100 - ($height - 100) / 20, 2), (int)$mass);
    
            fputcsv($result, $list);
        }
        fclose($result);
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
        $list[] = $index;
        $list[] = $norm;
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

