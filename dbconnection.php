<?php

try {
    $conn = new \PDO("mysql:host=database-firsttime.cw4lglw8pvam.eu-west-2.rds.amazonaws.com;dbname=library", "admin", "monkeyontree");

    return $conn;
}
catch(\PDOException $e) {
    echo $e->getMessage();
}
