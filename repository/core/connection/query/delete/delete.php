<?php
include_once __DIR__ . '/../../utils/configConnection.php';

/**
 * @param $tableName
 * @param $where
 * @return mixed|null
 */
function delete($tableName, $where)
{
    return tryConnection(function () use ($tableName, $where) {
        $conn = getConn();

        $sql = "DELETE FROM " . $tableName . " WHERE " . $where;

        $statement = $conn->prepare($sql);
        $statement->execute();

        return $statement->rowCount();
    });
}
