<?php

session_name(md5('blocker_gpge' . $_SERVER['REMOTE_ADDR'] . 'blocker_gpge' . $_SERVER['HTTP_USER_AGENT'] . 'blocker_gpge'));
session_start();

function esta_conectado($s)
{
    date_default_timezone_set("America/Bahia");
    return (isset($s['agent']) && isset($s['id']) && ($s['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) && !$s['concluido'] && (date('Y-m-d') <= $s['data_final']));
}

if (!esta_conectado($_SESSION))
{
    header("Location: ../index.php");
}

?>