<?php

require_once 'session.php';

function esta_conectado($s)
{
    date_default_timezone_set("America/Bahia");
    return (isset($s['acesso']) && $s['acesso'] && isset($s['agent']) && ($s['agent'] == md5($_SERVER['HTTP_USER_AGENT'])));
}

if (!esta_conectado($_SESSION))
{
    header("Location: /index.php");
}

?>