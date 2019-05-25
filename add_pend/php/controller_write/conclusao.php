<?php
require_once '../controle_acesso/conexao.php';
require_once '../funs.php';
require_once 'cgeral.php';

$p = &$_POST;

// Conexão com banco de dados
$con = con_db_gpge();

if ($con) {

    $id = value($p, 'tid');

    if ($id != null)
    {
        // Registra a data da última alteração do formulário e conclusão
        date_default_timezone_set("America/Bahia");
        $date = date('Y-m-d H:i:s');
        $sql_att = "UPDATE pge_pesquisa_gestao SET pge_concluido = ?, pge_data_ultima_alteracao = ? WHERE pge_id_pesquisa_gestao = ?";
        action($con, $sql_att, array(array(1, $date, $id)));

        echo "Submissão realizada com sucesso.";
    }

    // Encerra conexão e encaminha para próxima página
    $con = null;
    require_once '../controle_acesso/logout.php';
    header("Location: ../../index.php");
}
else
{
    echo "Falha durante a submissão.";
}

?>