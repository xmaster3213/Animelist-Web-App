<?php
require_once('common.php');
EnsureLogged();
require_once("bootstrap.php");

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['param'])) {
    // no id -> redirect to home
    Redirect('/home.php');
}

$param = $_GET['param'];
$users = $dbh->getUtenteLike($param);
$animes = $dbh->getAnimeLike($param);

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
    <link href="./css/search.css" rel="stylesheet"/>  
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <div class="results">
        <div class="result-col">
            <h3 class="title">Anime</h3>
            <?php foreach ($animes as $anime) { ?>
            <div class="result">
                <div>
                    <a href="anime.php?id=<?php echo $anime['id'] ?>">
                        <div class="image" style="background-image: url('<?php echo $anime['immagine_copertina']; ?>');"></div>
                        <div class="name">
                            <?php echo $anime['nome']; ?>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="result-col">
            <h3 class="title">Persone</h3>
            <?php foreach ($users as $user) { ?>
            <div class="result">
                <div>
                    <a href="animelist.php?username=<?php echo $user['username']; ?>">
                        <div class="image" style="background-image: url('<?php echo $user['immagine']; ?>');"></div>
                        <div class="name">
                            <?php echo $user['username']; ?>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>