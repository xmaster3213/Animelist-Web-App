<?php
require_once('common.php');
EnsureLogged();
require_once("bootstrap.php");

$animes = $dbh->getAllAnime();

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
    <link href="./css/home.css" rel="stylesheet"/> 
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <div class="results">
        <?php foreach ($animes as $anime) { ?>
        <div class="media-card" style="--media-text:hsl(42,37%,22%); --media-background:hsl(50,52%,75%); --media-background-text:hsl(42,37%,22%); --media-overlay-text:hsl(42,80%,70%);">
            <a href="anime.php?id=<?php echo $anime['id']; ?>" class="cover">
                <img src="<?php echo $anime['immagine_copertina']; ?>" alt="immagine copertina" class="image loaded">
            </a>
            <a href="anime.php?id=<?php echo $anime['id']; ?>" class="title">
                <?php echo $anime['nome']; ?>
            </a>
        </div>
        <?php } ?>
    </div>
</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>