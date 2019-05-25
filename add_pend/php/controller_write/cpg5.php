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
    
    if ($con) {
    
        $id = value($p, 'tid');
    
        if ($id != null)
        {
            // Verifica se possui avaliação interna e insere/altera os dados
            $existeAvaliacaoInterna = value($p, 'rAvaliacaoInterna');
            $sql_existe = "SELECT * FROM ain_avaliacao_interna WHERE ain_id_pesquisa_gestao = ?";
            if (!existe($con, $sql_existe, array($id)))
            {
                $sql_action = "INSERT INTO ain_avaliacao_interna (ain_id_pesquisa_gestao, ain_quais) VALUES (?, ?)";
                if ($existeAvaliacaoInterna)
                    $data = array(
                        $id,
                        value($p, 'taQuaisAvaliacoes')
                    );
                else
                    $data = array(
                        $id,
                        null
                    );
            }
            else
            {
                $sql_action = "UPDATE ain_avaliacao_interna SET ain_quais = ? WHERE ain_id_pesquisa_gestao = ?";
                if ($existeAvaliacaoInterna)
                    $data = array(
                        value($p, 'taQuaisAvaliacoes'),
                        $id
                    );
                else
                    $data = array(
                        null,
                        $id
                    );
            }
            // Aplica a ação
            action($con, $sql_action, array($data));
            //

            // Verificando se existe dados dos conselhos existentes na escola p/ inserir/excluir
            $conselhoExistente = value($p, 'cConselhosExistentes');
            if (!$conselhoExistente) $conselhoExistente = array();
            $conselhoOutro = value($p, 'tConselhosOutros');
            
            $data['i'] = array();
            $data['d'] = array();
            
            $sql_insert_coe = "INSERT INTO coe_conselho_escola (coe_id_pesquisa_gestao, coe_id_conselho) VALUES (?, ?)";
            $sql_delete_coe = "DELETE FROM coe_conselho_escola WHERE coe_id_pesquisa_gestao = ? AND coe_id_conselho = ?";
            $sql = "SELECT * FROM coe_conselho_escola INNER JOIN con_conselho ON coe_id_conselho = con_id_conselho WHERE coe_id_pesquisa_gestao = :id";
            
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            foreach ($row as $r)
            {
                if (($idConselho = $r['coe_id_conselho']) <= 1)
                {
                    // Verifica se o dado presente no banco não está listado na atualização
                    // Caso afirmativo adiciona para exclusão, caso contrário, retira da lista de insert "$conselhoExistente"
                    if (!in_array($idConselho, $conselhoExistente))
                        $data['d'][] = array($id, $idConselho);
                    else
                        unset($conselhoExistente[array_search($idConselho, $conselhoExistente)]);
                }
                else
                {
                    // Verifica se o nome do conselho "outro" é igual ao registrado
                    // Caso afirmativo retira da lista de inserção, caso contrário, adiciona para remoção do banco
                    if (in_array("O", $conselhoExistente) && $r['con_des_conselho'] == $conselhoOutro)
                        unset($conselhoExistente[array_search("O", $conselhoExistente)]);
                    else
                        $data['d'][] = array($id, $idConselho);
                }
            }
            foreach ($conselhoExistente as $c)
            {
                if($c != "O")
                    $data['i'][] = array($id, $c);
                else
                {
                    // Verifica o conselho "outro"
                    $sql_con = "SELECT max(con_id_conselho) FROM con_conselho";
                    $sql_select_con = "SELECT con_id_conselho, con_des_conselho FROM con_conselho WHERE con_des_conselho = ?";
                    if ($conselhoOutro)
                    {
                        if($idOutro = existe($con, $sql_select_con, array($conselhoOutro)))
                            $idOutro = $idOutro[1];
                        else
                        {
                            $idOutro = proxId($con, $sql_con);
                            $sql = "INSERT INTO con_conselho (con_id_conselho, con_des_conselho) VALUES (?, ?)";
                            action($con, $sql, array(array($idOutro, $conselhoOutro)));
                        }
                        $data['i'][] = array($id, $idOutro);
                    }
                }
            }
            // Aplica a ação insert
            action($con, $sql_insert_coe, $data['i']);
            // Aplica a ação delete
            action($con, $sql_delete_coe, $data['d']);
            //

            // Agentes existentes estaticamente no formulário
            $sql_agente = "SELECT * FROM age_agente LIMIT 9";
            $stmt = $con->query($sql_agente);
            $row = $stmt->fetchAll();
            $agentes = array();
            foreach ($row as $r) {
                //$agentes[] = utf8_encode($r['tem_des_tema']);
                $agentes[] = $r['age_des_agente'];
            }
            //

            // Verificando se existe dados dos agentes p/ inserir/excluir
            $agentesBaixoRendimento = explode("; ", value($p, 'taBaixoRendimento'));
            if (!$agentesBaixoRendimento) $agentesBaixoRendimento = array();
            $agenteOutro = value($p, 'tbrOutro');

            $data['i'] = array();
            $data['d'] = array();

            $sql_insert_bre = "INSERT INTO bre_baixo_rendimento (bre_id_pesquisa_gestao, bre_id_ordem_importancia, bre_id_agente) VALUES (?, ?, ?)";
            $sql_delete_bre = "DELETE FROM bre_baixo_rendimento WHERE bre_id_pesquisa_gestao = ? AND bre_id_agente = ?";
            $sql = "SELECT * FROM bre_baixo_rendimento INNER JOIN age_agente ON bre_id_agente = age_id_agente WHERE bre_id_pesquisa_gestao = :id";

            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            foreach ($row as $r)
            {
                //$agente = utf8_encode($r['age_des_agente']);
                $agente = $r['age_des_agente'];
                if (($idAgente = $r['bre_id_agente']) <= 8) {
                    // Verifica se o dado presente no banco não está listado na atualização
                    // Caso afirmativo adiciona para exclusão, caso contrário, retira da lista de insert "$agentesBaixoRendimento"
                    if (!in_array($agente, $agentesBaixoRendimento)) {
                        $data['d'][] = array($id, $idAgente);
                    } else {
                        unset($agentesBaixoRendimento[array_search($agente, $agentesBaixoRendimento)]);
                    }

                } else {
                    // Verifica se o nome do agente "outro" é igual ao registrado
                    // Caso afirmativo retira da lista de inserção, caso contrário, adiciona para remoção do banco
                    if ($agente == $agenteOutro) {
                        $agenteOutro = null;
                    } else {
                        $data['d'][] = array($id, $idAgente);
                    }

                }
            }
            $sql_ordem = "SELECT max(bre_id_ordem_importancia) FROM bre_baixo_rendimento WHERE bre_id_pesquisa_gestao = $id";
            $idOrdemAgente = proxId($con, $sql_ordem);
            foreach ($agentesBaixoRendimento as $c) {
                if (is_int($idTema = array_search($c, $agentes))) {
                    $data['i'][] = array($id, $idOrdemAgente, $idTema);
                } else {
                    // Verifica o agente "outro"
                    $sql_age = "SELECT max(age_id_agente) FROM age_agente";
                    $sql_select_age = "SELECT age_id_agente, age_des_agente FROM age_agente WHERE age_des_agente = ?";
                    if ($agenteOutro) {
                        if ($idOutro = existe($con, $sql_select_age, array($agenteOutro))) {
                            $idOutro = $idOutro[1];
                        } else {
                            $idOutro = proxId($con, $sql_age);
                            $sql = "INSERT INTO age_agente (age_id_agente, age_des_agente) VALUES (?, ?)";
                            action($con, $sql, array(array($idOutro, $agenteOutro)));
                        }
                        $data['i'][] = array($id, $idOrdemAgente, $idOutro);
                    }
                }
                $idOrdemAgente += 1;
            }
            // Aplica a ação insert
            action($con, $sql_insert_bre, $data['i']);
            // Aplica a ação delete
            action($con, $sql_delete_bre, $data['d']);
            //

            if (!($ideb2015 = value($p, 'nNotaIdeb2015'))) $ideb2015 = null;
            if (!($ideb2016 = value($p, 'nNotaIdeb2016'))) $ideb2016 = null;
            // Verifica se possui dados sobre as notas do ideb e insere/altera os dados
            $sql_existe = "SELECT * FROM nid_nota_ideb WHERE nid_id_pesquisa_gestao = ? AND nid_ano = ?";
            $sql_insert_nid = "INSERT INTO nid_nota_ideb (nid_id_pesquisa_gestao, nid_ano, nid_nota) VALUES (?, ?, ?)";
            $sql_update_nid = "UPDATE nid_nota_ideb SET nid_nota = ? WHERE nid_id_pesquisa_gestao = ? AND nid_ano = ?";
            $data['i'] = array();
            $data['u'] = array();
            // IDEB 2015 e 2016
            $notaIdeb = array(
                array('2015', $ideb2015),
                array('2016', $ideb2016)
            );
            foreach ($notaIdeb as $n)
            {
                if (!existe($con, $sql_existe, array($id, $n[0])))
                    $data['i'][] = array(
                        $id,
                        $n[0],
                        $n[1]
                    );
                else
                    $data['u'][] = array(
                        $n[1],
                        $id,
                        $n[0]
                    );
            }
            // Aplica a ação insert
            action($con, $sql_insert_nid, $data['i']);
            // Aplica a ação update
            action($con, $sql_update_nid, $data['u']);
            //

            if (!($nImportanciaDiretor = value($p, 'nImportanciaDiretor'))) $nImportanciaDiretor = null;
            // Verificando se deve ser inserido novo registro ou atualizado
            $sql_existe = "SELECT * FROM oge_organizacao_gestao_escola WHERE oge_id_pesquisa_gestao = ?";
            if (!existe($con, $sql_existe, array($id)))
            {
                $sql_action = "INSERT INTO oge_organizacao_gestao_escola (oge_id_pesquisa_gestao, oge_acompanhamento_pedagogico, oge_acoes_pedagogicas, oge_acoes_administrativas, oge_principais_problemas, oge_competencias_diretor, oge_avaliacao_interna, oge_importancia_diretor, oge_estrategia_melhoria_ideb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $data = array(
                    $id,
                    value($p, 'taAcompanhamentoPedagogico'),
                    value($p, 'taAcoesPedagogicas'),
                    value($p, 'taAcoesAdministrativas'),
                    value($p, 'taPrincipaisProblemas'),
                    value($p, 'taCompetenciasDiretor'),
                    $existeAvaliacaoInterna,
                    $nImportanciaDiretor,
                    value($p, 'taEstrategiaMelhoriaIdeb')
                );
            }
            else
            {
                $sql_action = "UPDATE oge_organizacao_gestao_escola SET oge_acompanhamento_pedagogico = ?, oge_acoes_pedagogicas = ?, oge_acoes_administrativas = ?, oge_principais_problemas = ?, oge_competencias_diretor = ?, oge_avaliacao_interna = ?, oge_importancia_diretor = ?, oge_estrategia_melhoria_ideb = ? WHERE oge_id_pesquisa_gestao = ?";
                $data = array(
                    value($p, 'taAcompanhamentoPedagogico'),
                    value($p, 'taAcoesPedagogicas'),
                    value($p, 'taAcoesAdministrativas'),
                    value($p, 'taPrincipaisProblemas'),
                    value($p, 'taCompetenciasDiretor'),
                    $existeAvaliacaoInterna,
                    $nImportanciaDiretor,
                    value($p, 'taEstrategiaMelhoriaIdeb'),
                    $id
                );
            }
            // Inserindo/Atualizando registro no banco de dados
            action($con, $sql_action, array($data));
            //

            // Registra a data da última alteração do formulário
            registraUltimaAlteracao($con, $id);
    
            echo "Submissão realizada com sucesso.";
        }
    
        // Encerra conexão e encaminha para próxima página
        $con = null;
        header("Location: ../../form/agradecimento.php");
    }
    else
    {
        echo "Falha durante a submissão.";
    }
}
else
{
    // Encaminha p/ próxima página caso a flag seja 0
    header("Location: ../../form/agradecimento.php");
}
/**/

?>