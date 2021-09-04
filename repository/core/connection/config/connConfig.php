<?php
include_once __DIR__ . "/../../config.php";

/**
 * @return PDO
 */
function getConn(): PDO
{
    $connData = getConnConfig();

    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
    ];

    return new PDO(
        'mysql:host=' . $connData["host"] . ';dbname=' . $connData["dbName"] . '',
        $connData["user"],
        $connData["pass"],
        $options
    );
}