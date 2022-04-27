<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

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

            <!-- Name input -->
            <div class="form-outline mb-4">
                <input type="text" id="nome" name="nome" class="form-control form-control-lg" maxlength="100" required/>
                <label class="form-label" for="nome">Nome</label>
            </div>

            <!-- Studio input -->
            <div class="form-outline mb-4">
                <input type="text" id="studio" name="studio" class="form-control form-control-lg" maxlength="50" required/>
                <label class="form-label" for="studio">Studio</label>
            </div>
            
            <!-- Trama input -->
            <div class="form-outline">
                <textarea class="form-control" id="trama" name="trama" maxlength="2000" rows="4"></textarea>
                <label class="form-label" for="trama">Trama</label>
            </div>

            <!-- Durata Episodi input -->
            <div class="form-outline">
                <input type="number" id="durata_episodi" name="durata_episodi" class="form-control" min="0"/>
                <label class="form-label" for="durata_episodi">Durata Episodi</label>
            </div>

            <!-- Numero Episodi input -->
            <div class="form-outline">
                <input type="number" id="numero_episodi" name="numero_episodi" class="form-control" min="0"/>
                <label class="form-label" for="numero_episodi">Numero Episodi</label>
            </div>

            <!-- Data Rilascio input -->
            <div class="form start">
                <input type="date" name="data_rilascio" id="data_rilascio" class="foreground">
                <label class="form-label" for="data_rilascio">Data Rilascio</label>
            </div>

            <!-- Immagine Copertina input -->
            <div class="form-outline mb-4">
                <input type="text" id="immagine_copertina" name="immagine_copertina" class="form-control form-control-lg" maxlength="100"/>
                <label class="form-label" for="iimmagine_copertina">Immagine Copertina</label>
            </div>

            <!-- Trailer input -->
            <div class="form-outline mb-4">
                <input type="text" id="trailer" name="trailer" class="form-control form-control-lg" maxlength="100"/>
                <label class="form-label" for="trailer">Trailer</label>
            </div>

            <input type="hidden" name="action" value="animeA">

            <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Aggiungi</button>
        </form>
        </div>
        </div>
    </section>
</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>