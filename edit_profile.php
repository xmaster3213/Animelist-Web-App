<?php
require_once('common.php');
EnsureLogged();

require_once("bootstrap.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$telefono = $_SESSION['telefono'];
$immagine = $_SESSION['immagine'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $new_username = $_POST['username'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $immagine = $_POST['immagine'];

    if ($dbh->editUtente($username, $new_username, $email, $telefono, $immagine)) {
        $_SESSION['username'] = $new_username;
        $_SESSION['email'] = $email;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['immagine'] = $immagine;

        Redirect('/profile.php');
        die();
    } else {
        $error = "Errore nell'aggiornamento del profilo";
    }
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
<?php require_once("navbar.php"); ?>
<section>
    <div class="container mt-4 py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <!-- Errore -->
        <?php if (isset($error)) {?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <!-- Username input -->
        <div class="form-outline mb-4">
            <input type="username" id="username" name="username" class="form-control form-control-lg" required maxlength="20" value="<?php echo $username; ?>"/>
            <label class="form-label" for="username">Username</label>
        </div>

        <!-- Email input -->
        <div class="form-outline mb-4">
            <input type="email" id="email" name="email" class="form-control form-control-lg" required maxlength="40" value="<?php echo $email; ?>"/>
            <label class="form-label" for="email">Email</label>
        </div>

        <!-- Password input -->
        <a href="edit_password.php" class="btn btn-primary mb-4" type="button">Modifica Password</a>

        <!-- Telefono -->
        <div class="form-outline mb-4">
            <input type="text" id="telefono" name="telefono" class="form-control form-control-lg" maxlength="13" value="<?php echo $telefono; ?>"/>
            <label class="form-label" for="telefono">Telefono</label>
        </div>

        <!-- Immagine -->
        <div class="form-outline mb-4">
            <input type="text" id="immagine" name="immagine" class="form-control form-control-lg" maxlength="100" value="<?php echo $immagine; ?>"/>
            <label class="form-label" for="immagine">Immagine</label>
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Modifica</button>
    </form>
    </div>
    </div>
  </section>  
  <script type="text/javascript" src="./js/mdb.min.js"></script>
</body>
</html>