<?php
require_once('common.php');
EnsureNotLogged();

require_once("bootstrap.php");

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['username'])
    && isset($_POST['email'])
    && isset($_POST['password'])
) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telefono = $_POST['telefono'];
    $immagine = $_POST['immagine'];

    if ($immagine === '') {
      $immagine = '/public/default_image.png';
    }

    if ($dbh->addNewUtente($username, $password, $email, $telefono, $immagine)) {
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['immagine'] = $immagine;
        $_SESSION['logged'] = true;
        $_SESSION['admin'] = false;

        header('Location: /home.php');
        die();
    } else {
        $error = "Errore nel creare l'account";
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
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <img src="public/logo.png" class="img-fluid" alt="Phone image" style="transform: scaleX(-1)">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <!-- Errore -->
            <?php if (isset($error)) {?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <!-- Username input -->
            <div class="form-outline mb-4">
              <input type="username" id="username" name="username" class="form-control form-control-lg" required maxlength="20"/>
              <label class="form-label" for="username">Username</label>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="email" name="email" class="form-control form-control-lg" required maxlength="40"/>
              <label class="form-label" for="email">Email</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="password" name="password" class="form-control form-control-lg" required maxlength="16"/>
              <label class="form-label" for="password">Password</label>
            </div>

            <!-- Telefono -->
            <div class="form-outline mb-4">
              <input type="number" id="telefono" name="telefono" class="form-control form-control-lg" maxlength="13"/>
              <label class="form-label" for="telefono">Telefono</label>
            </div>

            <!-- Immagine -->
            <div class="form-outline mb-4">
              <input type="text" id="immagine" name="immagine" class="form-control form-control-lg" maxlength="100"/>
              <label class="form-label" for="immagine">Immagine</label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Registrati</button>


            <div class="d-flex justify-content-around align-items-center">
              <p>Hai gia' un'account? <a href="signin.php" class="fw-bold">Accedi</a></p>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>    

  <script type="text/javascript" src="./js/mdb.min.js"></script>
</body>
</html>