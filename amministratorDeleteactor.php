<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['actor'])) {
    // no id -> redirect to home
    Redirect('/amministrator.php');
}

$dbh->delActor($_GET['actor']);
Redirect('/amministrator.php');
?>