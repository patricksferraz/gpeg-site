<?php
require_once '../controle_acesso/conexao.php';
require_once '../funs.php';
require_once '../controller_write/cgeral.php';

$p = &$_POST;
$data = [];

$con = con_db_gpge();

if ($con) {
    try
    {
        $inscrito = value($p, 'id_inscrito');
        $sql = "SELECT pes_nome, pes_sobrenome, pes_formacao, pes_email, tep_telefone, ine_apelido, des_nome_escola,
        CASE iep_respondeu_pesquisa
            WHEN 0 THEN 'Não'
            WHEN 1 THEN 'Sim'
        END AS 'respondeu_pesquisa', iep_temas_curso_preferencia
            FROM pes_pessoa INNER JOIN tep_telefone_pessoa
            ON tep_id_pessoa = pes_id_pessoa INNER JOIN ine_inscrito_evento
            ON ine_id_pessoa = pes_id_pessoa INNER JOIN iep_inscrito_evento_pesquisa
            ON iep_id_inscrito_evento = ine_id_inscrito_evento INNER JOIN des_dados_escola
            ON des_id_escola = iep_id_escola_pessoa
            WHERE ine_id_inscrito_evento = ?";
        $r = actionSelect($con, $sql, [$inscrito]);
        
        $data = Array(
            'nome' => ($r[0]['pes_nome'] . " " . $r[0]['pes_sobrenome']),
            'formacao' => $r[0]['pes_formacao'],
            'email' => $r[0]['pes_email'],
            'telefone' => $r[0]['tep_telefone'],
            'apelido' => $r[0]['ine_apelido'],
            'escola' => $r[0]['des_nome_escola'],
            'respondeu_pesquisa' => $r[0]['respondeu_pesquisa'],
            'temas' => $r[0]['iep_temas_curso_preferencia']
        );

        $con = null;
        echo json_encode($data);

    } catch (Exception $e) {

        $con = null;
        echo json_encode($data);

    }
} else {
    echo json_encode($data);
}

?>