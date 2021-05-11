<?php
/**
 * Created by PhpStorm.
 * User: Dusty
 * Date: 22.10.2015
 * Time: 22:32
 */
session_start();

if ((!isset($_SESSION['username']))&&(!isset($_COOKIE['username'])))
{
    header("Location: /login.php");
    die();
}

if ((!isset($_SESSION['username']))&&(isset($_COOKIE['username'])))
{
    $_SESSION['username'] = $_COOKIE['username'];
    if (isset($_COOKIE['page']))
    {
        header("Location: /{$_COOKIE['page']}.php");
        die();
    }
}


$username = $_SESSION['username'];