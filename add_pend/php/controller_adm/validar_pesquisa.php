<?php
require_once '../controle_acesso/conexao.php';
require_once '../funs.php';

$con = con_db_gpge();

if ($con) {
    try {
        //$inicio = value($p, 'inicio');
        date_default_timezone_set("America/Bahia");
        $date = date('Y-m-d');

        $sql = "SELECT * FROM peq_pesquisa WHERE peq_data_final_pesquisa >= ?";
        $stmt = $con->prepare($sql);
        $stmt->execute(array($date));
        $qt_row = $stmt->rowCount();
        $row = $stmt->fetch();

        $data_final = $row['peq_data_final_pesquisa'];
        
        $stmt = $row = $con = null;
        
        if ($qt_row)
            echo json_encode(array(true, $data_final));
        else
            echo json_encode(array(false));

    } catch (Exception $e) {

        $con = null;
        echo json_encode(array(false));

    }
} else {
    echo json_encode(array(false));
}
?>