<?php
require_once '../controle_acesso/conexao.php';
require_once '../funs.php';

$p = &$_POST;
$data = array();

$con = con_db_gpge();

if ($con) {
    try
    {
        $evento = value($p, 'evento');
        $sql = "SELECT * FROM pes_pessoa INNER JOIN ine_inscrito_evento
            ON ine_id_pessoa = pes_id_pessoa INNER JOIN iep_inscrito_evento_pesquisa
            ON iep_id_inscrito_evento = ine_id_inscrito_evento INNER JOIN eve_evento
            ON ine_id_evento = eve_id_evento INNER JOIN des_dados_escola
            ON iep_id_escola_pessoa = des_id_escola
            WHERE eve_id_evento = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute(array($evento));
        $row = $stmt->fetchAll();

        foreach ($row as $r) {
            $data[] = array(
                'id_inscrito' => $r['ine_id_inscrito_evento'],
                'nome' => $r['pes_nome'],
                'sobrenome' => $r['pes_sobrenome'],
                'apelido' => $r['ine_apelido'],
                'escola' => $r['des_nome_escola'],
                'municipio' => $r['des_municipio'],
                'respondeu_pesquisa' => $r['iep_respondeu_pesquisa'],
                'data_inscricao' => $r['ine_data_inscricao']
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