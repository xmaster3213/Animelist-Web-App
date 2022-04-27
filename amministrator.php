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
    <link href="./css/amministrator.css" rel="stylesheet"/>  
</head>
<body>
    <div class="container">
        <h1>Azioni Possibili</h1>
        <div class="wrapper">
            <?php foreach (array("anime", "actor") as $type) { ?>
            <div class="content">
                <h2><?php echo ucfirst($type) ?></h2>
                <form action="amministratorAdd<?php echo $type ?>.php" method="GET">
                    <button type="submit" class="btn btn-info" style="margin: auto;">Aggiungi <?php echo $type ?></button>
                </form>
                <form action="amministratorUpdate<?php echo $type ?>.php" method="GET">
                    <div class="form-outline">
                        <input type="text" id="<?php echo $type ?>U" name="<?php echo $type ?>" class="form-control form-control-lg" />
                        <label class="form-label" for="<?php echo $type ?>">ID</label>
                    </div>
                    <button type="submit" class="btn btn-info">Edita <?php echo $type ?></button>
                </form>
                <form action="amministratorDelete<?php echo $type ?>.php" method="GET">
                    <div class="form-outline">
                        <input type="text" id="<?php echo $type ?>D" name="<?php echo $type ?>" class="form-control form-control-lg" />
                        <label class="form-label" for="<?php echo $type ?>">ID</label>
                    </div>
                    <button type="submit" class="btn btn-info">Rimuovi <?php echo $type ?></button>
                </form>
            </div>
            <?php } ?>

            <?php foreach (array("episode", "character") as $type) { ?>
            <div class="content">
                <h2><?php echo ucfirst($type) ?></h2>
                <form action="amministratorAdd<?php echo $type ?>.php" method="GET">
                    <div class="form-outline">
                        <input type="text" id="<?php echo $type ?>A" name="<?php echo $type ?>ID_anime" class="form-control form-control-lg" />
                        <label class="form-label" for="<?php echo $type ?>">ID Anime</label>
                    </div>
                    <button type="submit" class="btn btn-info" style="margin: auto;">Aggiungi <?php echo $type ?></button>
                </form>
                <form action="amministratorUpdate<?php echo $type ?>.php" method="GET">
                    <div class="form-outline">
                        <input type="text" id="<?php echo $type ?>UID_anime" name="<?php echo $type ?>ID_anime" class="form-control form-control-lg" />
                        <label class="form-label" for="<?php echo $type ?>">ID Anime</label>
                    </div>
                    <div class="form-outline">
                        <input type="text" id="<?php echo $type ?>U" name="<?php echo $type ?>ID" class="form-control form-control-lg" />
                        <label class="form-label" for="<?php echo $type ?>">ID</label>
                    </div>
                    <button type="submit" class="btn btn-info">Edita <?php echo $type ?></button>
                </form>
                <form action="amministratorDelete<?php echo $type ?>.php" method="GET">
                    <div class="form-outline">
                        <input type="text" id="<?php echo $type ?>DID_anime" name="<?php echo $type ?>ID_anime" class="form-control form-control-lg" />
                        <label class="form-label" for="<?php echo $type ?>">ID Anime</label>
                    </div>
                    <div class="form-outline">
                        <input type="text" id="<?php echo $type ?>D" name="<?php echo $type ?>ID" class="form-control form-control-lg" />
                        <label class="form-label" for="<?php echo $type ?>">ID</label>
                    </div>
                    <button type="submit" class="btn btn-info">Rimuovi <?php echo $type ?></button>
                </form>
            </div>
            <?php } ?>
        </div>
        <div class="text-center">
            <a href="amministratorModifiche.php" class="btn btn-info btn-lg mt-5">Visualizza Modifiche Effetuate</a>
        </div>
    </div>

</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>