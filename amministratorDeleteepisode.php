<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

$animeid = setornull($_GET['episodeID_anime']);
$episodeid = setornull($_GET['episodeID']);
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || $animeid === null || $episodeid === null) {
    // no id -> redirect to home
    Redirect('/amministrator.php');
}

if ($dbh->delEpisode($animeid, $episodeid) !== false) {
    $dbh->addModifica($_SESSION['username'], $animeid);
}

Redirect('/amministrator.php');
?>