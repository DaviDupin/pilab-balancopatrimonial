<?php
    session_start();
    unset($_SESSION['uid'], $_SESSION['name']);

    $_SESSION['msg'] = "Deslogado com sucesso";
    header("Location: login.php");