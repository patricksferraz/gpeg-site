<?php

function data_pg5($con, $id)
{
    if ($con) {
        try
        {
            $sql = "SELECT oge_acompanhamento_pedagogico, oge_acoes_pedagogicas, oge_acoes_administrativas,
            oge_principais_problemas, oge_competencias_diretor, oge_avaliacao_interna, ain_quais,
            oge_importancia_diretor, oge_estrategia_melhoria_ideb
                FROM oge_organizacao_gestao_escola INNER JOIN ain_avaliacao_interna
                ON oge_id_pesquisa_gestao = ain_id_pesquisa_gestao
                WHERE oge_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $data['acompanhamento_pedagogico'] = $row['oge_acompanhamento_pedagogico'];
            $data['acoes_pedagogicas'] = $row['oge_acoes_pedagogicas'];
            $data['acoes_administrativas'] = $row['oge_acoes_administrativas'];
            $data['principais_problemas'] = $row['oge_principais_problemas'];
            $data['competencias_diretor'] = $row['oge_competencias_diretor'];
            $data['avaliacao_interna'] = $row['oge_avaliacao_interna'];
            $data['quais_avaliacoes'] = $row['ain_quais'];
            $data['importancia_diretor'] = $row['oge_importancia_diretor'];
            $data['melhoria_ideb'] = $row['oge_estrategia_melhoria_ideb'];

            // CONSELHO
            $sql = "SELECT * FROM coe_conselho_escola
                INNER JOIN con_conselho ON coe_id_conselho = con_id_conselho
                WHERE coe_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            $data['conselho'] = array();
            foreach ($row as $r)
            {
                if ($r['coe_id_conselho'] <= 1)
                    $data['conselho'][$r['coe_id_conselho']] = true;
                else
                    $data['conselho']['O'] = $r['con_des_conselho'];
            }

            // BAIXO RENDIMENTO
            $sql = "SELECT * FROM bre_baixo_rendimento
                INNER JOIN age_agente ON bre_id_agente = age_id_agente
                WHERE bre_id_pesquisa_gestao = :id
                ORDER BY bre_id_ordem_importancia ASC";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            $data['agente'] = array();
            foreach ($row as $r)
            {
                if ($r['bre_id_agente'] <= 8)
                    //$data['agente'][$r['bre_id_agente']] = utf8_encode($r['age_des_agente']);
                    $data['agente'][$r['bre_id_agente']] = $r['age_des_agente'];
                else
                    $data['agente']['O'] = $r['age_des_agente'];
            }
            $data['tBaixoRendimento'] = implode("; ", $data['agente']);

            // NOTA IDEB
            $sql = "SELECT * FROM nid_nota_ideb
                WHERE nid_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            $data['ideb'] = array();
            foreach ($row as $r)
                $data['ideb'][$r['nid_ano']] = $r['nid_nota'];

            $stmt = $row = null;

            return $data;

        } catch (Exception $e) {

            return array();

        }
    } else {
        return array();
    }

}
?>