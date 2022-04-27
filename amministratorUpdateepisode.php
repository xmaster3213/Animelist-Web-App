<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

if (
        $_SERVER['REQUEST_METHOD'] !== 'GET' || 
        !isset($_GET['episodeID_anime']) || 
        count($dbh->getAnime($_GET['episodeID_anime'])) == 0 ||
        !isset($_GET['episodeID']) || 
        count($dbh->getEpisode($_GET['episodeID_anime'], $_GET['episodeID'])) == 0
    ) {
    // no id -> redirect to home
    Redirect('/amministrator.php');
}

$episode = $dbh->getEpisode($_GET['episodeID_anime'], $_GET['episodeID']);
$titolo = $episode[0]['titolo'];
$thumbnail = $episode[0]['thumbnail'];

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
    <link href="./css/amministratorAction.css" rel="stylesheet"/>  
</head>
<body>
    <section>
        <div class="container mt-4 py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
        <form method="POST" action="actions.php" class="container">
            <!-- Errore -->
            <?php if (isset($error)) {?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <!-- Titolo input -->
            <div class="form-outline">
                <textarea id="titolo" name="titolo" class="form-control" maxlength="2000" rows="4" required><?php echo $titolo; ?></textarea>
                <label class="form-label" for="titolo">Titolo</label>
            </div>

            <!-- Studio input -->
            <div class="form-outline mb-4">
                <input type="text" id="thumbnail" name="thumbnail" class="form-control form-control-lg" maxlength="100" value="<?php echo $thumbnail; ?>"/>
                <label class="form-label" for="thumbnail">Thumbnail</label>
            </div>

            <input type="hidden" name="action" value="episodeU">
            <input type="hidden" name="idAnime" value="<?php echo $_GET['episodeID_anime'] ?>">
            <input type="hidden" name="number" value="<?php echo $_GET['episodeID'] ?>">

            <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Modifica</button>
        </form>
        </div>
        </div>
    </section>
</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>