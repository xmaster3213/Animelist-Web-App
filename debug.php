<?php
require_once("bootstrap.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbm
?>


<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="query"/>
</form>