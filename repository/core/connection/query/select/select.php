<?php
include_once __DIR__ . '/../../utils/configConnection.php';

/**
 * @param $tableName
 * @return mixed|null
 */
function select($tableName)
{
    return tryConnection(function () use ($tableName) {
        $conn = getConn();
        $sql = "SELECT * FROM " . $tableName;

        $statement = $conn->prepare($sql);
        $statement->execute();
        return convertArray($statement);
    });
}

/**
 * @param $tableName
 * @param $where
 * @return mixed|null
 */
function selectWhere($tableName, $where)
{
    return tryConnection(function () use ($tableName, $where) {
        $conn = getConn();
        $sql = "SELECT * FROM " . $tableName . " WHERE " . $where;
        $statement = $conn->prepare($sql);
        $statement->execute();
        return convertArray($statement);
    });
}

/**
 * @param $tableName
 * @param $where
 * @return mixed|null
 */
function selectRow($tableName, $where)
{
    return tryConnection(function () use ($tableName, $where) {
        $conn = getConn();
        $sql = "SELECT * FROM " . $tableName . " WHERE " . $where;

        $statement = $conn->prepare($sql);
        $statement->execute();
        return convert($statement);
    });
}

/**
 * @param $tableName
 * @param $columnName
 * @return mixed|null
 */
function selectRowDuplicates($tableName, $columnName)
{
    return tryConnection(function () use ($tableName, $columnName) {
        $conn = getConn();
        $sql = "SELECT * FROM
        " . $tableName . "
        GROUP BY  " . $columnName . "
        HAVING COUNT( " . $columnName . ") > 1";

        $statement = $conn->prepare($sql);
        $statement->execute();
        return convertArray($statement);
    });
}

/**
 * @param $tableName
 * @param null $case
 * @return mixed|null
 */
function selectCase($tableName, $case = null)
{
    return tryConnection(function () use ($tableName, $case) {
        $caseWrite = $case !== null ? $case : "";

        $conn = getConn();
        $sql = "SELECT * " . $caseWrite . " FROM " . $tableName;

        $statement = $conn->prepare($sql);
        $statement->execute();
        return convertArray($statement);
    });
}


