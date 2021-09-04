<?php
/**
 * include core.php for create connections file for your website
 */
include_once __DIR__ . '/core/core.php';

/**
 * after include core, create your functions for your website
 *
 * Examples.:
 */
function getRace(): array
{
    return select('race');
}

function getRaceByID($id)
{
    return selectRow('race', "id = " . $id);
}

function getRaceByAtk(): array
{
    return selectWhere('race', "atk = 1");
}

function insertRace($array)
{
    return insert('race', $array);
}

function updateRace($array, $id)
{
    return update('race', $array, "id = " . $id);
}

function deleteRace($id)
{
    return delete('race', "id = " . $id);
}
