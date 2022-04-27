<?php
require_once('common.php');
EnsureLogged();
require_once("bootstrap.php");

$id = setornull($_GET['id']);
if ($id === null) {
    // no id -> redirect to home
    Redirect('/home.php');
}

$anime = indexornull($dbh->getAnime($id), 0);
if ($anime === null) {
    // anime not found
    Redirect('/home.php');
}

$nome = $anime['nome'];
$studio = $anime['studio'];
$trama = $anime['trama'];
$durata_episodi = $anime['durata_episodi'];
$voto_medio = $anime['voto_medio'];
$data_rilascio = $anime['data_rilascio'];
$numero_episodi = $anime['numero_episodi'];
$immagine_copertina = $anime['immagine_copertina'];
$trailer = $anime['trailer'];

$personaggi = $dbh->getAnimeCharacters($id);
$episodes = $dbh->getEpisodes($id);

$entry = indexornull($dbh->getListaEntry($id, $_SESSION['username']), 0);

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
    <link href="./css/anime.css" rel="stylesheet"/>  
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <div class="container">
        <div class="cover-wrapper">
            <img src="<?php echo $immagine_copertina; ?>" class="cover">
            <div class="action<?php echoc($entry === null, ' action-grid'); ?>">
                <?php if ($entry === null) { ?>
                    <a href="edit.php?id=<?php echo $id; ?>&status=COMPLETATO" class="white" style="background-color: rgb(61,180,242);">Completato</a> 
                    <a
                        style="background-color: rgb(105, 180, 221);"
                        class="dropdown-toggle d-flex align-items-center hidden-arrow white"
                        href="#"
                        id="navbarDropdownMenuLink"
                        role="button"
                        data-mdb-toggle="dropdown"
                        aria-expanded="false"
                    >
                        ...
                    </a>
                    <ul
                        class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="navbarDropdownMenuLink"
                    >
                        <li>
                            <a class="dropdown-item black" href="edit.php?id=<?php echo $id; ?>&status=COMPLETATO">Completato</a>
                        </li>
                        <li>
                            <a class="dropdown-item black" href="edit.php?id=<?php echo $id; ?>&status=VISIONE PIANIFICATA">Visione Pianificata</a>
                        </li>
                        <li>
                            <a class="dropdown-item black" href="edit.php?id=<?php echo $id; ?>&status=IN VISIONE">In Visione</a>
                        </li>
                    </ul>
                <?php } else { ?>
                    <a href="edit.php?id=<?php echo $id; ?>" class="white" style="background-color: rgb(61,180,242);"><?php echo ucwords(strtolower($entry['stato'])); ?></a> 
                <?php } ?>
            </div>
        </div>
        <div class="content">
            <h1>
                <?php echo $nome; ?>
            </h1>
            <p class="description">
                <?php echo (is_null($trama) ? "<i>Trama non ancora inserita</i>" : $trama); ?>
            </p>
        </div>
    </div>
    <div class="categories">
     <!-- Tabs navs -->
     <ul class="nav nav-tabs mb-3" id="ex1" role="tablist" style="background-color: white;">
        <li class="nav-item" role="presentation">
            <a
            class="nav-link active"
            id="ex1-tab-1"
            data-mdb-toggle="tab"
            href="#ex1-tabs-1"
            role="tab"
            aria-controls="ex1-tabs-1"
            aria-selected="true"
            >Informazioni</a
            >
        </li>
        <li class="nav-item" role="presentation">
            <a
            class="nav-link"
            id="ex1-tab-2"
            data-mdb-toggle="tab"
            href="#ex1-tabs-2"
            role="tab"
            aria-controls="ex1-tabs-2"
            aria-selected="false"
            >Personaggi</a
            >
        </li>
        <li class="nav-item" role="presentation">
            <a
            class="nav-link"
            id="ex1-tab-3"
            data-mdb-toggle="tab"
            href="#ex1-tabs-3"
            role="tab"
            aria-controls="ex1-tabs-3"
            aria-selected="false"
            >Episodi</a
            >
        </li>
    </ul>
    <!-- Tabs navs -->

    <!-- Tabs content -->
    <div class="tab-content" id="ex1-content" style="background-color: #f4f5f7;">
        <!-- Overview -->
        <div
            class="tab-pane fade show active"
            id="ex1-tabs-1"
            role="tabpanel"
            aria-labelledby="ex1-tab-1"
        >
            <div class="content-container">
                <div class="data">
                    <div class="data-set">
                        <div class="type">
                            Studio
                        </div>
                        <div class="value">
                            <?php echo $studio; ?>
                        </div>
                    </div>
                    <?php if (!is_null($durata_episodi)) { ?>
                    <div class="data-set">
                        <div class="type">
                            Durata Episodi
                        </div>
                        <div class="value">
                            <?php echo $durata_episodi; ?> min
                        </div>
                    </div>
                    <?php } ?>
                    <?php if (!is_null($data_rilascio)) { ?>
                    <div class="data-set">
                        <div class="type">
                            Numero Episodi
                        </div>
                        <div class="value">
                            <?php echo $numero_episodi; ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if (!is_null($voto_medio)) { ?>
                    <div class="data-set">
                        <div class="type">
                            Voto Medio
                        </div>
                        <div class="value">
                            <?php echo $voto_medio; ?>/100
                        </div>
                    </div>
                    <?php } ?>
                    <?php if (!is_null($data_rilascio)) { ?>
                        <div class="data-set">
                            <div class="type">
                                Data Rilascio
                            </div>
                            <div class="value">
                                <?php echo $data_rilascio; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <?php if (!is_null($trailer)) { ?>
                    <h2>
                        Trailer
                    </h2>
                    <iframe src="<?php echo $trailer; ?>" frameborder="0" allowfullscreen="allowfullscreen" class="video"></iframe>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- End Overview -->

        <!-- Characters -->
        <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
            <div class="grid-wrap">
                <?php foreach ($personaggi as $personaggio) { ?>
                    <div class="character-card">
                        <div class="character">
                            <a href="character.php?anime=<?php echo $id; ?>&character=<?php echo $personaggio['charid']; ?>" class="character-image" style="background-image: url('<?php echo $personaggio['charimg']; ?>');"></a>
                            <a href="character.php?anime=<?php echo $id; ?>&character=<?php echo $personaggio['charid']; ?>" class="content">
                                <?php echo $personaggio['charname']; ?>
                            </a>
                        </div>
                        <div class="staff">
                            <a href="actor.php?actor=<?php echo $personaggio['staffid']; ?>" class="character-image" style="background-image: url('<?php echo $personaggio['staffimg']; ?>');"></a>
                            <a href="actor.php?actor=<?php echo $personaggio['staffid']; ?>" class="content">
                                <?php echo $personaggio['staffname']; ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- End Characters -->

        <!-- Episodes -->
        <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
            <div class="watch">
                <?php foreach ($episodes as $episode) { ?>
                    <a class="episode" style="background-image: url('<?php echo $episode['thumbnail']; ?>');">
                        <div class="title"><?php echo $episode['titolo']; ?></div>
                    </a>
                <?php } ?>
            </div>
        </div>
        <!-- End Episodes -->
    </div>
    <!-- Tabs content -->
    </div>
    <script type="text/javascript" src="./js/mdb.min.js"></script>
</body>
</html>