<?php
include_once __DIR__ . '/../../utils/configConnection.php';

function insert($tableName, $array)
{
    return tryConnection(function () use ($tableName, $array) {

        $sthInsert = createArrayStatement($array);
        $conn = getConn();

        $sql = "INSERT INTO " . $tableName . " 
        (" . implode(', ', array_keys($array)) . ") 
        VALUES 
        (:" . implode(', :', array_keys($array)) . ")";

        $statement = $conn->prepare($sql);
        $statement->execute($sthInsert);

        return $statement->rowCount();
    });
}
