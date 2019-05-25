<?php
require_once '../controle_acesso/conexao.php';
require_once '../funs.php';
require_once 'cgeral.php';

$p = &$_POST;

/**
* Flag = 0 não realiza atualização no banco
* Flag = 1 indica que o POST possui dados atualizados
*/
if (value($p, 'flag') == 1)
{
    // Conexão com banco de dados
    $con = con_db_gpge();
    
    if ($con)
    {
        $id = value($p, 'tid');
    
        if ($id != null)
        {
            // Variáveis p/ armazenar valores dos inserts e updates
            $data['i'] = array();
            $data['u'] = array();
            //
            
            // Verificando se deve ser inserido novo registro ou atualizado
            $sql_existe = "SELECT * FROM fge_formacao_gestor WHERE fge_id_pesquisa_gestao = ? AND fge_id_nivel_formacao = ?";

            if (!existe($con, $sql_existe, array($id, 0))) $data['i'][] = array($id, 0, value($p, 'tLicenciatura'));
            else $data['u'][] = array(value($p, 'tLicenciatura'), $id, 0);

            if (!existe($con, $sql_existe, array($id, 1))) $data['i'][] = array($id, 1, value($p, 'tBacharelado'));
            else $data['u'][] = array(value($p, 'tBacharelado'), $id, 1);

            if (!existe($con, $sql_existe, array($id, 2))) $data['i'][] = array($id, 2, value($p, 'tEspecializacao'));
            else $data['u'][] = array(value($p, 'tEspecializacao'), $id, 2);
            //

            /**
            * Verifica qual checkbox foi selecionada e deleta os outros dados da formação
            * mantendo apenas o de maior formação
            */
            $nvl_fo = value($p, 'rNivelFormacao');
            if ($nvl_fo)
            {
                $sql_delete = "DELETE FROM fge_formacao_gestor WHERE fge_id_pesquisa_gestao = ? AND fge_id_nivel_formacao = ?";

                switch ($nvl_fo)
                {
                    case 'mestrado':
                        action($con, $sql_delete, array(array($id,4), array($id,5), array($id,6)));
                        if (!existe($con, $sql_existe, array($id, 3))) $data['i'][] = array($id, 3, value($p, 'tAreaMestrado'));
                        else $data['u'][] = array(value($p, 'tAreaMestrado'), $id, 3);
                        break;

                    case 'mestrando':
                        action($con, $sql_delete, array(array($id, 3), array($id, 5), array($id, 6)));
                        if (!existe($con, $sql_existe, array($id, 4))) $data['i'][] = array($id, 4, value($p, 'tAreaMestrando'));
                        else $data['u'][] = array(value($p, 'tAreaMestrando'), $id, 4);
                        break;

                    case 'doutor':
                        action($con, $sql_delete, array(array($id, 3), array($id, 4), array($id, 6)));
                        if (!existe($con, $sql_existe, array($id, 5))) $data['i'][] = array($id, 5, value($p, 'tAreaDoutorado'));
                        else $data['u'][] = array(value($p, 'tAreaDoutorado'), $id, 5);
                        break;

                    case 'doutorando':
                        action($con, $sql_delete, array(array($id, 3), array($id, 4), array($id, 5)));
                        if (!existe($con, $sql_existe, array($id, 6))) $data['i'][] = array($id, 6, value($p, 'tAreaDoutorando'));
                        else $data['u'][] = array(value($p, 'tAreaDoutorando'), $id, 6);
                        break;
                        
                    default:
                }
            }
            /**/

            // Realiza os Inserts e updates aplicáveis
            $sql_insert = "INSERT INTO fge_formacao_gestor (fge_id_pesquisa_gestao, fge_id_nivel_formacao, fge_des_formacao) VALUES (?, ?, ?)";
            $sql_update = "UPDATE fge_formacao_gestor SET fge_des_formacao = ? WHERE fge_id_pesquisa_gestao = ? AND fge_id_nivel_formacao = ?";
            action($con, $sql_insert, $data['i']);
            action($con, $sql_update, $data['u']);

            // Registra a data da última alteração do formulário
            registraUltimaAlteracao($con, $id);

            echo "Submissão realizada com sucesso.";
        }
    
        // Encerra conexão e encaminha para próxima página
        $con = null;
        header("Location: ../../form/perfil_gestor.php");
    }
    else
    {
        echo "Falha durante a submissão.";
    }
}
else
{
    // Encaminha p/ próxima página caso a flag seja 0
    header("Location: ../../form/perfil_gestor.php");
}

?>