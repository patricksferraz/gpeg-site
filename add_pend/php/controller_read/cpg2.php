<?php

function data_pg2($con, $id)
{
    if ($con) {
        try
        {

            $sql = "SELECT peg_genero, peg_id_faixa_etaria, peg_exerceu_gestao_antes,
            peg_id_tempo_gestao_antes, peg_id_rede_escola_antes, peg_gestor_qnts_vezes,
            peg_ch_semanal_gestao
                FROM peg_perfil_gestor
                WHERE peg_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $data['genero'] = $row['peg_genero'];
            $data['faixa_etaria'] = $row['peg_id_faixa_etaria'];
            $data['exerceu_gestao'] = $row['peg_exerceu_gestao_antes'];
            $data['rede_escola'] = $row['peg_id_rede_escola_antes'];
            $data['vezes_gestor'] = $row['peg_gestor_qnts_vezes'];
            $data['ch_gestor'] = $row['peg_ch_semanal_gestao'];

            $sql = "SELECT tge_anos, tge_meses
                FROM peg_perfil_gestor INNER JOIN tge_tempo_gestao
                ON tge_id_tempo_gestao = peg_id_tempo_gestao_atual
                WHERE peg_id_pesquisa_gestao = ?";
            $stmt = $con->prepare($sql);

            $stmt->execute(array($id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $data['tempo_gestao_atual_anos'] = $row['tge_anos'];
            $data['tempo_gestao_atual_meses'] = $row['tge_meses'];

            $sql = "SELECT tge_anos, tge_meses
                FROM peg_perfil_gestor INNER JOIN tge_tempo_gestao
                ON tge_id_tempo_gestao = peg_id_tempo_gestao_antes
                WHERE peg_id_pesquisa_gestao = ?";
            $stmt = $con->prepare($sql);

            $stmt->execute(array($id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $data['tempo_gestao_antes_anos'] = $row['tge_anos'];
            $data['tempo_gestao_antes_meses'] = $row['tge_meses'];

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