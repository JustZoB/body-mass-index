<?php
    const TABLE_COL = 3;

    $indexsArray = ['IMT', 'Brok', 'Breytman', 'Berngard', 'Davenport', 'Noorden', 'Tatony'];
    
    function readGuys() : array
    {
        $guys = [];
        $row = 0;
        $file = [];
        if (($file = fopen('guys.csv', 'r')) !== FALSE) {
            while (($line = fgetcsv($file, 1000, ',')) !== FALSE) {  
                for ($i = 0; $i < TABLE_COL; $i++) {
                    if ($i == 0) {
                        $guys[$row]['mass'] = $line[$i];
                    } elseif ($i == 1) {
                        $guys[$row]['height'] = $line[$i];
                    } else {
                        $guys[$row]['chest'] = $line[$i];
                    }
                }
                $row++;
            }
            fclose($file);
        }

        return $guys;
    }

    function readARGV(array $argv) : array
    {
        global $row;
        for ($i = 1; $i < count($argv); $i++) {
            if ($i % TABLE_COL == 1) {
                $guys[$row]['mass'] = $argv[$i];
            } elseif ($i % TABLE_COL == 2) {
                $guys[$row]['height'] = $argv[$i];
            } else {
                $guys[$row]['chest'] = $argv[$i];
            }
            if ($i % TABLE_COL == 0) {
                $row++;
            }
        }

        return $guys;
    }
    function addHeaders() : array
    {
        global $guyscount, $indexsArray;
        $resultArray = []; 
        $resultArray[$guyscount][] = 'Mass';
        $resultArray[$guyscount][] = 'Height';
        $resultArray[$guyscount][] = 'Chest';
        foreach ($indexsArray as $name) {
            $resultArray[$guyscount][] = "$name";
            $resultArray[$guyscount][] = "$name norm";
        }
        $guyscount++;

        return $resultArray;
    }

    function createIndex(string $name, float $index, int $mass)
    {
        $norm = norm($name, $index, $mass);
        echo "Index $name: $index, Norm $name: $norm \n";
    }

    function createIndexCSV(string $name, float $index, int $mass)
    {
        global $resultArray, $guyscount;
        $norm = norm($name, $index, $mass);

        $resultArray[$guyscount]["$name"] = $index;
        $resultArray[$guyscount]["Norm $name"] = $norm;
    }

    function norm(string $name, float $index, int $mass) : string 
    {
        if ($name == 'IMT') {
            $norm = normIMT($index);
        } elseif ($name == 'Davenport') {
            $norm = normDavenport($index);
        } else {
            $norm = normOther($index, $mass);
        }
        return $norm;
    }
    
    function normOther(float $index, int $mass) : string
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

    function IMT(int $height, int $mass) : float 
    {
        return $mass * 10000 / ($height ** 2);
    }
    function Brok(int $height) : float 
    {
        return $height - 100;
    }
    function Breytman(int $height) : float 
    {
        return $height * 0.7 - 50;
    }
    function Berngard( int $height, int $mass, int $chest) : float 
    {
        return $chest * $height / 240;
    }
    function Davenport(int $height, int $mass) : float 
    {
        return $mass * 1000 / ($height ** 2);
    }
    function Noorden(int $height) : float 
    {
        return $height * 0.42;
    }
    function Tatony(int $height) : float 
    {
        return $height - 100 - ($height - 100) / 20;
    }
?>