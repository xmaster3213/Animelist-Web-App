<?php
require_once('common.php');
EnsureLogged();

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$telefono = $_SESSION['telefono'];
$immagine = $_SESSION['immagine'];
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
<body style="background-color: #f4f5f7;">
    <?php require_once("navbar.php"); ?>
  <section class="mt-4">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-6 mb-4 mb-lg-0">
          <div class="card mb-3" style="border-radius: .5rem;">
            <div class="row mt-3 g-0">
              <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                <img
                  src="<?php echo $immagine; ?>"
                  alt="Avatar"
                  class="img-fluid mt-3 mb-1"
                  style="width: 120px; height: 120px; border-radius: 50%;"
                />
                <h5 class="text-black mb-2"><?php echo $username; ?></h5>
                <a href="edit_profile.php"><i class="far fa-edit mb-4"></i></a>
              </div>
              <div class="col-md-8">
                <div class="card-body p-4">
                  <h6>Informazioni</h6>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <h6>Email</h6>
                      <p class="text-muted"><?php echo (!empty($email) ? $email : 'None') ?></p>
                    </div>
                    <div class="col-6 mb-3">
                      <h6>Phone</h6>
                      <p class="text-muted"><?php echo (!empty($telefono) ? $telefono : 'None'); ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    
  <script type="text/javascript" src="./js/mdb.min.js"></script>
</body>
</html>
