<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

if (
        $_SERVER['REQUEST_METHOD'] !== 'GET' || 
        !isset($_GET['characterID_anime']) || 
        count($dbh->getAnime($_GET['characterID_anime'])) == 0 ||
        !isset($_GET['characterID']) || 
        count($dbh->getCharacter($_GET['characterID_anime'], $_GET['characterID'])) == 0
    ) {
    // no id -> redirect to home
    Redirect('/amministrator.php');
}

$character = $dbh->getCharacter($_GET['characterID_anime'], $_GET['characterID']);
$doppiatore = $character[0]['id_doppiatore'];
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

            <!-- Nome input -->
            <div class="form-outline mb-4">
                <input type="text" id="nome" name="nome" class="form-control form-control-lg" maxlength="30" required value="<?php echo $nome; ?>"/>
                <label class="form-label" for="nome">Nome</label>
            </div>

            <!-- Descrizione input -->
            <div class="form-outline">
                <textarea class="form-control" id="descrizione" name="descrizione" required rows="4"><?php echo $descrizione; ?></textarea>
                <label class="form-label" for="descrizione">Descrizione</label>
            </div>

            <!-- ID Doppiatore input -->
            <div class="form-outline">
                <input type="number" id="id_doppiatore" name="id_doppiatore" class="form-control" min="0" value="<?php echo $doppiatore; ?>"/>
                <label class="form-label" for="id_doppiatore">ID Doppiatore</label>
            </div>

            <!-- Immagine input -->
            <div class="form-outline mb-4">
                <input type="text" id="immagine" name="immagine" class="form-control form-control-lg" maxlength="100" value="<?php echo $immagine; ?>"/>
                <label class="form-label" for="immagine">Immagine</label>
            </div>

            <input type="hidden" name="action" value="characterU">
            <input type="hidden" name="idAnime" value="<?php echo $_GET['characterID_anime'] ?>">
            <input type="hidden" name="id" value="<?php echo $_GET['characterID'] ?>">

            <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Modifica</button>
        </form>
        </div>
        </div>
    </section>
</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>