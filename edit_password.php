<?php
require_once('common.php');
EnsureLogged();

require_once("bootstrap.php");

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $password = $_POST['password'];

    $successful = $dbh->editPassword($username, $password);
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
</head>
<body>
<section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">

    <?php if (isset($successful) && $successful === true) { ?>
        <div class="alert alert-success" role="alert">
        Password aggiornata. <a href="/profile.php">Vai al profilo</a>.
        </div>
    <?php } else { ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <!-- Errore -->
            <?php if (isset($successful) && $successful === false) {?>
                <div class="alert alert-danger" role="alert">
                    Errore nell'aggiornamento della password. <a href="/edit_password.php">Riprova</a> oppure <a href="/profile.php">vai al profilo</a>.
                </div>
            <?php } ?>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control form-control-lg" required maxlength="16"/>
                <label class="form-label" for="password">Password</label>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Modifica</button>
        </form>
    <?php } ?>
    </div>
    </div>
  </section>  
  <script type="text/javascript" src="./js/mdb.min.js"></script>
</body>
</html>