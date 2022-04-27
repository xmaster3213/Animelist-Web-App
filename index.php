<?php
require_once('common.php');

if (IsLogged()) {
    Redirect('/home.php');
} else {
    Redirect('/signin.php');
}
