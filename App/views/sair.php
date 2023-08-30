<?php

session_start();// Inicializar a sessão
$_SESSION = array();// Limpar a sessão
session_unset();// Limpar a sessão
session_destroy();// Destruir a sessão

// Direcionar para a pagina de login
header("location: index.php");
       