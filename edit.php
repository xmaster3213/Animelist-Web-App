<?php
require_once('common.php');
EnsureLogged();
require_once("bootstrap.php");

$id = setor($_GET['id'], setornull($_POST['id']));
if ($id === null) {
    // no id
    die('noid');
    Redirect('/home.php');
}

$animeInfo = indexornull($dbh->getAnimeGeneralInfo($id), 0);
if ($animeInfo === null) {
    // anime non trovato
    die('notfound');
    Redirect('/home.php');
}
$nome = $animeInfo['nome'];
$immagine_copertina = $animeInfo['immagine_copertina'];
$numero_episodi = $animeInfo['numero_episodi'];

$stato = setor($_GET['status'], "IN VISIONE");

$entry = indexornull($dbh->getListaEntry($id, $_SESSION['username']), 0);
if ($entry !== null) {
    $stato = $entry['stato'];
    $voto = $entry['voto'];
    $data_inizio = $entry['data_inizio'];
    $data_fine = $entry['data_fine'];
    $episodi_visti = $entry['episodi_visti'];
    $voto = $entry['voto'];
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['status'], $_POST['voto'], $_POST['episodi_visti'], $_POST['data_inizio'], $_POST['data_fine'])
) {
    if (isset($_POST['delete'])) {
        $dbh->deleteListaEntry($id, $_SESSION['username']);
    } else {
        $stato = $_POST['status'];
        $data_inizio = nullifempty($_POST['data_inizio']);
        $data_fine = nullifempty($_POST['data_fine']);
        $voto = nullifempty($_POST['voto']);
        $episodi_visti = nullifempty($_POST['episodi_visti']);
        
        if ($dbh->addOrUpdateListaEntry($_SESSION['username'], $id, $stato, $data_inizio, $data_fine, $episodi_visti, $voto) === false) {
            die("Errore durante l'aggiunta dell'anime");
        }
    }

    $dbh->updateVotoMedio($id);

    Redirect('/animelist.php');
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniProj</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link href="./css/mdb.min.css" rel="stylesheet"/>
    <link href="./css/edit.css" rel="stylesheet"/>  
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <div class="header" data-src="null" lazy="error">
                <div class="content">
                    <div class="cover">
                        <img src="<?php echo $immagine_copertina; ?>" alt="immagine copertina">
                    </div>
                    <div class="title">
                        <?php echo $nome; ?>
                    </div>
                    <div class="top-right-btn">
                        <button class="btn btn-danger mr-1" type="submit" name="delete"">Delete</button>
                        <input class="btn btn-primary" type="submit" style="background-color: rgb(61,180,242);" value="Salva">
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="form status">
                    <div class="input-title">Stato</div>
                    <select class="form-select form-select-sm foreground" name="status" aria-label=".form-select-sm example">
                        <option <?php echoc($stato == "COMPLETATO", "selected"); ?> value="COMPLETATO">Completato</option>
                        <option <?php echoc($stato == "IN VISIONE", "selected"); ?> value="IN VISIONE">In Visione</option>
                        <option <?php echoc($stato == "VISIONE PIANIFICATA", "selected"); ?> value="VISIONE PIANIFICATA">Visione Pianificata</option>
                        <option <?php echoc($stato == "ABBANDONATO", "selected"); ?> value="ABBANDONATO">Abbandonato</option>
                    </select>
                </div>
                <div class="form score">
                    <div class="input-title">Voto</div>
                    <div class="form-outline foreground">
                        <input type="number" id="voto" name="voto" class="form-control" min="0" max="10" value="<?php echo $voto; ?>"/>
                    </div>
                </div>
                <div class="form progres">
                    <div class="input-title">Episodio Corrente</div>
                    <div class="form-outline foreground">
                        <input type="number" id="episodi_visti" name="episodi_visti" class="form-control" min="0" max="<?php echo $numero_episodi; ?>" value="<?php echo $episodi_visti; ?>"/>
                    </div>
                </div>
                <div class="form start">
                    <div class="input-title">Data Inizio</div>
                    <input type="date" name="data_inizio" id="data_inizio" class="foreground" value="<?php echo $data_inizio; ?>">
                </div>
                <div class="form finish">
                    <div class="input-title">Data Fine</div>
                    <input type="date" name="data_fine" id="data_fine" class="foreground" value="<?php echo $data_fine; ?>">
                </div>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>