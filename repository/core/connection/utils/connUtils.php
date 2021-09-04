<?php
/**
 * @param $value
 * @return string
 */
function toSqlInsetParameter($value)
{
    return $value === NULL ? 'NULL' : "'" . addslashes(trim($value)) . "'";
}

function printJson($data)
{
    header('Content-Type: application/json');
    $json_string = json_encode($data, JSON_PRETTY_PRINT);
    echo $json_string;
}

function jsonToArray($json): array
{
    return json_decode($json, JSON_BIGINT_AS_STRING | JSON_OBJECT_AS_ARRAY);
}

/**
 * @param $result
 * @param $conn
 * @param $sql
 * @param bool $onlyError
 */
function showConnResult($result, $conn, $sql, $onlyError = false)
{
    if ($onlyError) {
        if (!$result) {
            echo "<b>ERROR!!!</b> " . mysqli_error($conn) . "<br>";
        }
    } else {
        if (!$result) {
            echo "<b>ERROR!!!</b> " . mysqli_error($conn) . "<br>" . $sql . "<br>";
        } else {
            echo "Ok ->" . $sql . "<br>";
        }
    }
}