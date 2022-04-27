<?php
require_once('common.php');
EnsureLogged();

require_once("bootstrap.php");

if (isset($_GET['username']) && strcasecmp($_GET['username'], $_SESSION['username']) !== 0) {
    $editable = false;
    $username = $_GET['username'];
    if (!$dbh->userExists($username)) {
        Redirect('/home.php');
    }
} else {
    $editable = true;
    $username = $_SESSION['username'];
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
    <link href="./css/site.css" rel="stylesheet"/>
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <?php foreach (array("COMPLETATO", "VISIONE PIANIFICATA", "IN VISIONE", "ABBANDONATO") as $category) { ?>
        <div class="list">
            <div class="list-header">
                <?php echo $category; ?>
            </div>
            <div class="list-anime">
                <div class="head">
                    <div class="cover"></div>
                    <div class="title" style="font-weight: bold;">Titolo</div>
                    <div class="score" style="font-weight: bold;">Punteggio</div>
                    <div class="episodes" style="font-weight: bold;">Episodi</div>
                    <?php if ($editable) { ?>
                        <div class="edit"></div>
                    <?php } ?>
                </div>

                <?php 
                    $animes = $dbh->getAnimelistGivenStato($username, $category);
                    foreach ($animes as $anime) {
                ?> 
                    <div class="anime">
                        <div class="cover">
                            <div class="image" style="background-image: url('<?php echo $anime['immagine_copertina']; ?>');">

                            </div>
                        </div>
                        <div class="title">
                            <a href="anime.php?id=<?php echo $anime['id']; ?>">
                                <?php echo $anime['nome']; ?>
                            </a>
                        </div>
                        <div class="score">
                            <?php echo $anime['voto']; ?>
                        </div>
                        <div class="episodes">
                            <span><?php echo (is_null($anime['episodi_visti']) ? 0 : $anime['episodi_visti']); ?></span><span>/</span><?php
                                if (!is_null($anime['numero_episodi'])) {
                            ?><span><?php
                                echo $anime['numero_episodi'];
                            ?></span>
                            <?php } ?>
                        </div>
                        <?php if ($editable) { ?>
                            <a href="edit.php?id=<?php echo $anime['id']; ?>">
                                <div class="edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                <?php }?>
            </div>
        </div>
    <?php }?>
    <script type="text/javascript" src="./js/mdb.min.js"></script>
</body>
</html>