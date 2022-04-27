<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

$action = setornull($_POST['action']);
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $action === null) {
    // no id -> redirect to home
    Redirect('/amministrator.php');
}

$id = setornull($_POST['idAnime']);

switch ($action) {
    case "animeU":
        $successful = $dbh->editAnime($_POST['idAnime'], $_POST['nome'], $_POST['studio'], nullifempty($_POST['trama']), nullifempty($_POST['durata_episodi']), nullifempty($_POST['numero_episodi']), nullifempty($_POST['data_rilascio']), nullifempty($_POST['immagine_copertina']), nullifempty($_POST['trailer']));
        break;
    case "animeA":
        $successful = $id = $dbh->addAnime($_POST['nome'], $_POST['studio'], nullifempty($_POST['trama']), nullifempty($_POST['durata_episodi']), nullifempty($_POST['numero_episodi']), nullifempty($_POST['data_rilascio']), nullifempty($_POST['immagine_copertina']), nullifempty($_POST['trailer']));
        break;
    case "episodeU":
        $successful = $dbh->editEpisode($_POST['idAnime'], $_POST['number'], $_POST['titolo'], nullifempty($_POST['thumbnail']));
        break;
    case "episodeA":
        $successful = $dbh->addEpisode($_POST['idAnime'], $_POST['number'], $_POST['titolo'], nullifempty($_POST['thumbnail']));
        break;
    case "characterU":
        $successful = $dbh->editCharacter($_POST['idAnime'], $_POST['id'], $_POST['nome'], $_POST['descrizione'], nullifempty($_POST['immagine']), nullifempty($_POST['id_doppiatore']));
        break;
    case "characterA":
        $successful = $dbh->addCharacter($_POST['idAnime'], $_POST['nome'], $_POST['descrizione'], nullifempty($_POST['immagine']), nullifempty($_POST['id_doppiatore']));
        break;
    case "actorU":
        $dbh->editActor($_POST['id'], $_POST['nome'], nullifempty($_POST['immagine']), $_POST['info']);
        break;
    case "actorA":
        $dbh->addActor($_POST['nome'], nullifempty($_POST['immagine']), $_POST['info']);
        break;
}

if (isset($successful) && $successful !== false) {
    $dbh->addModifica($_SESSION['username'], $id);
}

Redirect('/amministrator.php');

?>