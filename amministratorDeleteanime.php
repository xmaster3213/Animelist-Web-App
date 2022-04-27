<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

$id = setornull($_GET['anime']);
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || $id === null) {
    // no id -> redirect to home
    Redirect('/amministrator.php');
}

$dbh->delAnime($id) !== false;

Redirect('/amministrator.php');
?>