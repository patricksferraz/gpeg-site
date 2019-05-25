<?php

function logar($con, $login, $senha)
{
    if ($con) {
        try
        {

            $sql = "SELECT usr_id_usuario, usr_apelido, usr_nome, usr_email, usr_senha
                FROM usr_usuario
                WHERE usr_apelido = :login OR usr_email = :login";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('login' => $login));
            $qt_row = $stmt->rowCount();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $return = array();

            if ($qt_row && (md5($senha) == $row['usr_senha']))
            {
                $id_usuario = $row['usr_id_usuario'];
                $apelido = $row['usr_apelido'];
                $nome = $row['usr_nome'];
                $email = $row['usr_email'];
                $return = array('flag' => 0, 'id_usuario' => $id_usuario, 'apelido' => $apelido, 'nome' => $nome, 'email' => $email);
            }

            $stmt = $row = null;

            return $return;

        } catch (Exception $e) {

            return array('flag' => 1, 'erro' => $e);

        }
    } else {
        return false;
    }
}

?>