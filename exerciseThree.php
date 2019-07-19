<?php
    $row = 0;
    if (($guys = fopen("guys.csv", "r")) !== FALSE) {
    $result = fopen("result.csv", "w+");
    $headers = array('Id', 'Mass', 'Height', 'BMI', 'Broke', 'Breytman', 'Berngard', 'Davenport', 'Noorden', 'Tatonya', 'Broke', 'Breytman', 'Berngard', 'Davenport', 'Noorden', 'Tatonya');
    fputcsv($result, $headers);
        while (($data = fgetcsv($guys, 1000, ",")) !== FALSE) {
            $row++;
            for ($c=0; $c < 4; $c++) {
                if ($c == 0) $mass = $data[$c]; 
                elseif ($c == 1) $height = $data[$c];
                elseif ($c == 2) $age = $data[$c];
                elseif ($c == 3) $chest = $data[$c];
            }
            $index = round($mass / ($height ** 2), 2);
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

            $list = array($row,$mass,$height,$index, $indexBroka, $indexBreytmana, $indexBerngarda, $indexDavenporta, $indexNoordena, $indexTatonya, $normBroka, $normBreytmana, $normBerngarda, $normDavenporta, $normNoordena, $normTatonya);
            fputcsv($result, $list);
        }
    fclose($guys);
    fclose($result);
    }
?>