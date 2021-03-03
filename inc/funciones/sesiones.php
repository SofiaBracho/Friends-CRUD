<?php

function usuario_autenticado() {
    if(!revisar_usuario()) {
        header('Location:login.php');
        echo "<script>location.href='login.php';</script>";
        exit();
    }
}

function revisar_usuario() {
    return isset($_SESSION['id']);
}