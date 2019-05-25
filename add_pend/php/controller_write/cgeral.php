<?php

function existe($con, $sql, $data) {
    try {
        $ret = 0;
        
        $stmt = $con->prepare($sql);
        $stmt->execute($data);
        $qnt_row = $stmt->rowCount();
        $row = $stmt->fetch();
        if ($qnt_row) $ret = array(1, $row[0]);

        $stmt = $qnt_row = $row = null;

        return $ret;

    } catch (Exception $e) {
        return null;   
    }
}

function action ($con, $sql, $data) {
    try {
        $con->beginTransaction();
        $sth = $con->prepare($sql);
        foreach ($data as $d) {
            $sth->execute($d);
        }
        $con->commit();

        $sth = null;

        return 1;

    } catch (Exception $e) {
        return null;
    }
}

function actionSelect ($con, $sql, $data = null) {
    try {
        $stmt = $con->prepare($sql);
        if ($data) $stmt->execute($data);
        else $stmt->execute();
        $row = $stmt->fetchAll();
        
        $stmt = null;
        return $row;

    } catch (Exception $e) {
        return null;
    }
}

function proxId($con, $sql) {
    try {
        $stmt = $con->query($sql);
        $row = $stmt->fetch();

        $prox_id = $row[0]+1;

        $stmt = $row = null;

        return $prox_id;

    } catch (Exception $e) {
        return false;
    }
}

function registraUltimaAlteracao($con, $id) {
    try {
        date_default_timezone_set("America/Bahia");
        $date = date('Y-m-d H:i:s');
        $sql_att = "UPDATE pge_pesquisa_gestao SET pge_data_ultima_alteracao = ? WHERE pge_id_pesquisa_gestao = ?";
        action($con, $sql_att, array(array($date, $id)));

        return true;
        
    } catch (Exception $e) {
        return false;
    }
}

?>