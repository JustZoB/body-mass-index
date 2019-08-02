<?php
declare (strict_types=1);

$link = mysqli_connect("127.0.0.1", "justzob", "ei7veeChu4bo");
if (!$link) {
    die('Ошибка соединения: ' . mysqli_connect_error());
}

$sql = 'CREATE DATABASE ibm';
if (mysqli_query($link, $sql)) {
    echo "База my_db успешно создана\n";
    echo "Информация о сервере: " . mysqli_get_host_info($link) . PHP_EOL;
} else {
    echo 'Ошибка при создании базы данных: ' . mysqli_error($link) . "\n";
}