<?php
session_start();

function IsLogged() {
    return isset($_SESSION['logged']) && $_SESSION['logged'] === true;
}

function Redirect($url) {
    header('Location: ' . $url);
    die();
}

function EnsureLogged() {
    if (!IsLogged()) {
        Redirect('/signin.php');
    }
}

function EnsureNotLogged() {
    if (IsLogged()) {
        Redirect('/home.php');
    }
}

function EnsureAdmin() {
    if ($_SESSION['admin'] !== true) {
        Redirect('/home.php');
    }
}

function setornull(&$var = null) {
    return $var;
}

function setor(&$var, $def) {
    if (isset($var)) {
        return $var;
    } else {
        return $def;
    }
}

function nullifempty($var) {
    if ($var === '') {
        return null;
    }
    return $var;
}

function indexornull($arr, $index) {
    if (count($arr) > $index) {
        return $arr[$index];
    }
    return null;
}

function echoc($bool, $str) {
    if ($bool === true) {
        echo $str;
    }
}