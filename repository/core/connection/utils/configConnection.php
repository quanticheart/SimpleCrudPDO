<?php
include_once __DIR__ . '/../config/connConfig.php';
include_once __DIR__ . '/connUtils.php';

/**
 * @param Closure $closure
 * @return mixed|null
 */
function tryConnection(Closure $closure)
{
    try {
        return $closure();
    } catch (PDOException | Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return null;
    }
}

/**
 * @param PDOStatement $statement
 * @return array|null
 */
function convertArray(PDOStatement $statement): ?array
{
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $index => $row) {
            $results[$index] = (object)verifyData($row, getColumnMeta($statement));
        }
        return $results;
    } else {
        return null;
    }
}

/**
 * @param PDOStatement $statement
 * @return object|null
 */
function convert(PDOStatement $statement): ?object
{
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (sizeof($row) > 0) {
        return (object)verifyData($row, getColumnMeta($statement));
    } else {
        return null;
    }
}

/**
 * @param PDOStatement $statement
 * @return array
 */
function getColumnMeta(PDOStatement $statement): array
{
    $columnTypes = array();
    foreach (range(0, $statement->columnCount() - 1) as $column_index) {
        $meta = $statement->getColumnMeta($column_index);
        $columnTypes[$meta['name']] = $meta['native_type'];
    }
    return $columnTypes;
}

/**
 * @param $row
 * @param $columnTypes
 * @return mixed
 */
function verifyData($row, $columnTypes)
{
    if (sizeof($columnTypes) > 0) {
        foreach ($row as $col => $value) {
            if ($value !== null)
                switch ($columnTypes[$col]) {
                    case 'DECIMAL':
                    case 'NUMERIC':
                    case 'FLOAT':
                    case 'DOUBLE':
                        $row[$col] = (float)$value;
                        break;
                    case 'LONG':
                    case 'INTEGER':
                    case 'INT':
                    case 'BIGINT':
                    case 'MEDIUMINT':
                    case 'TINYINT':
                    case 'SMALLINT':
                        $row[$col] = (int)$value;
                        break;
                    case 'BOOLEAN':
                    case 'BOOL':
                    case 'TINY':
                        $row[$col] = boolval($value);
                        break;
                }
        }

    }
    return $row;
}

function createArrayStatement($array): array
{
    $statementArray = array();
    foreach ($array as $k => $v) {
        $statementArray[':' . $k] = $v;
    }
    return $statementArray;
}
