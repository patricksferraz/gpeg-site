<?php
require_once '../controle_acesso/conexao.php';
require_once '../funs.php';

$p = &$_POST;
$data = array();

$con = con_db_gpge();

if ($con) {
    try
    {
        $periodo = value($p, 'periodo');
        $sql = "SELECT * FROM peq_pesquisa INNER JOIN pge_pesquisa_gestao
            ON peq_id_pesquisa = pge_id_pesquisa INNER JOIN des_dados_escola
            ON pge_id_escola = des_id_escola
            WHERE peq_id_pesquisa = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute(array($periodo));
        $row = $stmt->fetchAll();

        foreach ($row as $r) {
            $ultimaAlteracao = $r['pge_data_ultima_alteracao'];

            $data[] = array(
                'id_escola' => $r['des_id_escola'],
                'codigo_acesso' => $r['pge_hash_pesquisa'],
                'nome_escola' => $r['des_nome_escola'],
                'municipio' => $r['des_municipio'],
                'email' => $r['des_email'],
                'ultima_alteracao' => $ultimaAlteracao,
                'situacao' => $r['pge_concluido'],
                'id_pesquisa' => $r['peq_id_pesquisa'],
                'id_pesquisa_gestao' => $r['pge_id_pesquisa_gestao']
            );
        }

        $stmt = $row = null;

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