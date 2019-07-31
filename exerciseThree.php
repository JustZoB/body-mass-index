<?php
declare (strict_types=1);
require_once 'functions.php';
arrayToCsv(peopleToArray(readPeople('people.csv'), true));