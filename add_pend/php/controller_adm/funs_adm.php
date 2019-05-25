<?php

function selectPesquisa($con) {
    if ($con) {
        try {
            $sql = "SELECT peq_id_pesquisa, peq_data_inicio_pesquisa, peq_data_final_pesquisa FROM peq_pesquisa ORDER BY peq_data_inicio_pesquisa DESC";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchAll();

            $data = array();
            foreach ($row as $r)
                $data[] = array($r['peq_id_pesquisa'], $r['peq_data_inicio_pesquisa'], $r['peq_data_final_pesquisa']);

            $stmt = $row = null;

            return $data;

        } catch (Exception $e) {

            return array();

        }
    } else {
        return array();
    }
}

function selectEvento($con) {
    if ($con) {
        try {
            $sql = "SELECT eve_id_evento, eve_data_inicio, eve_titulo FROM eve_evento ORDER BY eve_data_inicio DESC";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchAll();

            $data = array();
            foreach ($row as $r)
                $data[] = [$r['eve_id_evento'], $r['eve_data_inicio'], $r['eve_titulo']];

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