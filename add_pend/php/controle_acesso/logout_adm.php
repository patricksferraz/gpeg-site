<?php

require_once 'session.php';
session_destroy(); // Destrói a sessão limpando todos os valores salvos
unset($_SESSION);
header("location: ../../index.php");

?>