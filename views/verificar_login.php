<?php
session_start();

// Verifica se o administrador está logado
if (!isset($_SESSION['nome_usuario'])) {

// Redireciona caso não esteja logado
    header("Location: ../index.php");
    exit;
}
