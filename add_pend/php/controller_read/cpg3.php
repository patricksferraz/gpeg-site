<?php

function data_pg3($con, $id)
{
    if ($con) {
        try
        {
            $sql = "SELECT sog_id_obtencao_cargo, sog_participou_curso, cge_quantidade_curso, cge_quando_ultimo, cge_qual_ultimo, cge_tema_abordado,
            cge_id_colaboracao_curso, sog_temas_desenvolver_gestor, sog_id_preparacao_formacao, sog_justificativa_preparacao_formacao,
            sog_caracterizacao_bom_gestor
                FROM sog_sobre_gestao INNER JOIN cge_curso_gestao
                ON sog_id_pesquisa_gestao = cge_id_pesquisa_gestao
                WHERE sog_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $id_sog_obtencao_cargo = $row['sog_id_obtencao_cargo'];
            $data['participou_curso'] = $row['sog_participou_curso'];
            $data['qnt_curso'] = $row['cge_quantidade_curso'];
            $data['quando_ultimo_curso'] = $row['cge_quando_ultimo'];
            $data['qual_ultimo_curso'] = $row['cge_qual_ultimo'];
            $data['tema_abordado'] = $row['cge_tema_abordado'];
            $data['colaboracao'] = $row['cge_id_colaboracao_curso'];
            $data['temas_desenvolver'] = $row['sog_temas_desenvolver_gestor'];
            $data['preparacao_curso'] = $row['sog_id_preparacao_formacao'];
            $data['justificativa_preparacao'] = $row['sog_justificativa_preparacao_formacao'];
            $data['caracterizacao'] = $row['sog_caracterizacao_bom_gestor'];

            $sql = "SELECT oca_id_obtencao_cargo, oca_des_obtencao_cargo
                FROM oca_obtencao_cargo
                WHERE oca_id_obtencao_cargo = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id_sog_obtencao_cargo));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $data['id_obtencao_cargo'] = $row['oca_id_obtencao_cargo'];
            $data['obtencao_cargo'] = $row['oca_des_obtencao_cargo'];

            // TEMA FORMAÇÂO
            $sql = "SELECT * FROM tfo_tema_formacao
                INNER JOIN tem_tema ON tfo_id_tema = tem_id_tema
                WHERE tfo_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            $data['temaFormacao'] = array();
            foreach ($row as $r)
            {
                if ($r['tfo_id_tema'] <= 11)
                    //$data['temaFormacao'][$r['tfo_id_tema']] = utf8_encode($r['tem_des_tema']);
                    $data['temaFormacao'][$r['tfo_id_tema']] = $r['tem_des_tema'];
                else
                    $data['temaFormacao']['O'] = $r['tem_des_tema'];
            }

            // TEMA FORMAÇÂO DESENVOLVIMENTO
            $sql = "SELECT * FROM tfd_tema_formacao_desenvolvimento
                INNER JOIN tem_tema ON tfd_id_tema = tem_id_tema
                WHERE tfd_id_pesquisa_gestao = :id
                ORDER BY tfd_id_ordem_importancia ASC";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            $data['temaFormacaoDesenvolvimento'] = array();
            foreach ($row as $r)
            {
                if ($r['tfd_id_tema'] <= 11)
                    //$data['temaFormacaoDesenvolvimento'][$r['tfd_id_tema']] = utf8_encode($r['tem_des_tema']);
                    $data['temaFormacaoDesenvolvimento'][$r['tfd_id_tema']] = $r['tem_des_tema'];
                else
                    $data['temaFormacaoDesenvolvimento']['O'] = $r['tem_des_tema'];
            }
            $data['tTemaFormacaoDesenvolvimento'] = implode("; ", $data['temaFormacaoDesenvolvimento']);

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