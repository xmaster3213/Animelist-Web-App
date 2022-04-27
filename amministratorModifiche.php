<?php
require_once('common.php');
EnsureAdmin();
require_once("bootstrap.php");

$edits = $dbh->getModifiche();
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
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">User</th>
                    <th scope="col">Anime</th>
                    <th scope="col">Data</th>
                    <th scope="col">Ora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($edits as $edit) { ?>
                        <tr>
                        <th scope="row"><?php echo $edit['amministratore']; ?></th>
                        <td><?php 
                        echo $edit['id_anime'];
                        if (isset($edit['nome'])) {
                            echo ' (' . $edit['nome'] . ')';
                        }
                        ?></td>
                        <td><?php echo $edit['data']; ?></td>
                        <td><?php echo $edit['ora']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
    </section>
</body>
<script type="text/javascript" src="./js/mdb.min.js"></script>
</html>