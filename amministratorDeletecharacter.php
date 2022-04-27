<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

$id = setornull($_GET['characterID_anime']);
$charid = setornull($_GET['characterID']);
if (
    $_SERVER['REQUEST_METHOD'] !== 'GET' || 
    $id === null ||
    $charid === null
) {
    // no id -> redirect to home
    Redirect('/amministrator.php');
}

if ($dbh->delCharacter($id, $charid) !== false) {
    $dbh->addModifica($_SESSION['username'], $id);
}

Redirect('/amministrator.php');
?>