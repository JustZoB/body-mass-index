<?php
require_once 'functions.php';

if (isset($_POST['mass'], $_POST['height'], $_POST['chest'])) {
    if (validSubmit([(float)$_POST['mass'], (float)$_POST['height'], (float)$_POST['chest']])) {
        $human[] = [
            'mass' => (float)$_POST['mass'],
            'height' => (float)$_POST['height'],
            'chest' => (float)$_POST['chest']
        ];
        writeCsv(getResult($human, true));
    }
}
