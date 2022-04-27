<?php
require_once('common.php');
EnsureLogged();
require_once("bootstrap.php");

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['anime']) || !isset($_GET['character']) || count($dbh->getCharacter($_GET['anime'], $_GET['character'])) == 0) {
    // no id -> redirect to home
    Redirect('/home.php');
}

$idAnime = $_GET['anime'];
$idCharacter = $_GET['character'];

$character = $dbh->getCharacter($idAnime, $idCharacter);
$nome = $character[0]['nome'];
$descrizione = $character[0]['descrizione'];
$immagine = $character[0]['immagine'];

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
    <link href="./css/character.css" rel="stylesheet"/>  
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <div class="character">
        <div class="header">
            <div class="container">
                <img src="<?php echo $immagine ?>" alt="Immagine Personaggio" class="image">
                <div></div>
                <h1 class="name"><?php echo $nome ?></h1>
            </div>
        </div>
        <div class="body container">
                    <div></div>
                    <div class="description-wrap">
                        <div class="description">
                            <?php echo $descrizione ?>
                        </div>
                    </div>
                </div>
    </div>
</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>