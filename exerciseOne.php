<?php
    $row = 0;
    if (($guys = fopen("guys.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($guys, 1000, ",")) !== FALSE) {
            $row++;
            for ($c=0; $c < 4; $c++) {
                if ($c == 0) $mass = $data[$c]; 
                elseif ($c == 1) $height = $data[$c];
                elseif ($c == 2) $age = $data[$c];
                elseif ($c == 3) $chest = $data[$c];
            }
            $indexIMT = round($mass / ($height ** 2), 2);
            $heightSM = $height * 100;
            $indexBroka = round($heightSM - 100, 2);
            $indexBreytmana = round($heightSM * 0.7 - 50, 2);
            $indexBerngarda = round($chest * $heightSM / 240, 2);
            $indexDavenporta = round($mass * 1000 / (($heightSM ** 2)), 2);
            $indexNoordena = round($heightSM * 0.42, 2);
            $indexTatonya = round($heightSM - 100 - ($heightSM - 100) / 20, 2);

            if ((($indexBroka - 15) > $mass) || (($indexBroka + 15) < $mass)) $normBroka = "не норма"; else $normBroka = "норма";
            if ((($indexBreytmana - 15) > $mass) || (($indexBreytmana + 15) < $mass)) $normBreytmana = "не норма"; else $normBreytmana = "норма";
            if ((($indexBerngarda - 15) > $mass) || (($indexBerngarda + 15) < $mass)) $normBerngarda = "не норма"; else $normBerngarda = "норма";
            if (($indexDavenporta > 3) or ($indexDavenporta < 1)) $normDavenporta = "не норма"; else $normDavenporta = "норма";
            if ((($indexNoordena - 15) > $mass) || (($indexNoordena + 15) < $mass)) $normNoordena = "не норма"; else $normNoordena = "норма";
            if ((($indexTatonya - 15) > $mass) || (($indexTatonya + 15) < $mass)) $normTatonya = "не норма"; else $normTatonya = "норма";

            echo "Id: $row, Масса: $mass, Рост: $height, Возраст: $age, Окружность грудной клетки: $chest, Индекс массы тела: $indexIMT, \n \n";
            echo "Индекс Брока: $indexBroka, Индекс Брейтмана: $indexBreytmana, Индекс Бернгарда: $indexBerngarda, \n";
            echo "Индекс Давенпорта: $indexDavenporta, Индекс Ноордена: $indexNoordena, Индекс Татоня: $indexTatonya. \n \n";
            echo "Норма по Броку: $normBroka, Норма по Брейтману: $normBroka, Норма по Бернгарду: $normBroka, \n";
            echo "Норма по Давенпорту: $normBroka, Норма по Ноордену: $normBroka, Норма по Татоню: $normBroka, \n \n \n";
        }
    fclose($guys);
    }
?>