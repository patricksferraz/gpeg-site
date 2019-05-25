<?php

require_once 'class.conexao.php';


function con_db_gpge()
{
    try
    {
        $dns = "mysql:host=localhost;dbname=db_gpge";
        $usr = "ferraz";
        $pas = "#W4ri013Rr";

        $con = new Conexao($dns, $usr, $pas);
        return $con->getConexao();
    }
    catch (Exception $e)
    {
        return false;
    }

}

?>