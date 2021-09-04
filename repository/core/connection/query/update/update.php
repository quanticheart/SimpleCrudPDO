<?php
include_once __DIR__ . '/../../utils/configConnection.php';

/**
 * @param $tableName
 * @param $array
 * @param $where
 * @return mixed|null
 */
function update($tableName, $array, $where)
{
    return tryConnection(function () use ($tableName, $array, $where) {
        $sthInsert = createArrayStatement($array);

        $data = "";
        foreach ($array as $key => $value) {
            if ($value !== NULL) {
                if ($data === "") {
                    $data = "$key = :" . $key . "";
                } else {
                    $data = "$data, $key = :" . $key . "";
                }
            }
        }

        $conn = getConn();

        $sql = "UPDATE " . $tableName . " SET " . $data . " WHERE " . $where . "";

        $statement = $conn->prepare($sql);
        $statement->execute($sthInsert);

        return $statement->rowCount();
    });
}

/**
 * @param $tableName
 * @param $array
 * @param $where
 * @return mixed|null
 */
function updateWithNull($tableName, $array, $where)
{
    return tryConnection(function () use ($tableName, $array, $where) {
        $sthInsert = createArrayStatement($array);

        $data = "";
        foreach ($array as $key => $value) {
            if ($data === "") {
                $data = "$key = :" . $key . "";
            } else {
                $data = "$data,$key = :" . $key . "";
            }
        }

        $conn = getConn();

        $sql = "UPDATE " . $tableName . " SET " . $data . " WHERE " . $where . "";

        $statement = $conn->prepare($sql);
        $statement->execute($sthInsert);

        return $statement->rowCount();
    });
}

