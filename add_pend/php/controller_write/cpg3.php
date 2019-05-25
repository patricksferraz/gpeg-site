<?php
require_once '../controle_acesso/conexao.php';
require_once '../funs.php';
require_once 'cgeral.php';

$p = &$_POST;

/**
 * Flag = 0 não realiza atualização no banco
 * Flag = 1 indica que o POST possui dados atualizados
 */
if (value($p, 'flag') == 1) {
    // Conexão com banco de dados
    $con = con_db_gpge();

    if ($con) {

        $id = value($p, 'tid');

        if ($id != null) {
            // Verificando se participou de curso ou não
            $participouCurso = value($p, 'rCursoGestao');

            if (!($qtCurso = value($p, 'nQntCurso'))) {
                $qtCurso = null;
            }
            if (!($qndUltimoCurso = value($p, 'nQuandoUltimoCurso'))) {
                $qndUltimoCurso = null;
            }
            // Verifica se deve inserir/atualiza os dados de acordo com a participacao
            $sql_existe = "SELECT * FROM cge_curso_gestao WHERE cge_id_pesquisa_gestao = ?";
            if (!existe($con, $sql_existe, array($id))) {
                $sql_action = "INSERT INTO cge_curso_gestao (cge_id_pesquisa_gestao, cge_quantidade_curso, cge_quando_ultimo, cge_qual_ultimo, cge_tema_abordado, cge_id_colaboracao_curso) VALUES (?, ?, ?, ?, ?, ?)";
                if ($participouCurso) {
                    $data = array(
                        $id,
                        $qtCurso,
                        $qndUltimoCurso,
                        value($p, 'tQualUltimoCurso'),
                        value($p, 'taTemaAbordado'),
                        value($p, 'rColaboracaoCurso')
                    );
                } else {
                    $data = array(
                        $id,
                        null,
                        null,
                        null,
                        null,
                        null
                    );
                }

            } else {
                $sql_action = "UPDATE cge_curso_gestao SET cge_quantidade_curso = ?, cge_quando_ultimo = ?, cge_qual_ultimo = ?, cge_tema_abordado = ?, cge_id_colaboracao_curso = ? WHERE cge_id_pesquisa_gestao = ?";
                if ($participouCurso) {
                    $data = array(
                        $qtCurso,
                        $qndUltimoCurso,
                        value($p, 'tQualUltimoCurso'),
                        value($p, 'taTemaAbordado'),
                        value($p, 'rColaboracaoCurso'),
                        $id
                    );
                } else {
                    $data = array(
                        null,
                        null,
                        null,
                        null,
                        null,
                        $id
                    );
                }

            }
            // Realiza a ação escolhida
            action($con, $sql_action, array($data));
            //

            // Verificando se existe dados da obtenção do cargo do gestor p/ inserir
            $idObteveCargo = value($p, 'rObteveCargo');
            $obteveCargo = value($p, 'tObteveCargo');

            $sql_oca = "SELECT oca_id_obtencao_cargo FROM oca_obtencao_cargo WHERE oca_des_obtencao_cargo = ?";

            if (($idObteveCargo == "O") && $obteveCargo) {
                if ($idObteveCargo = existe($con, $sql_oca, array($obteveCargo))) {
                    $idObteveCargo = $idObteveCargo[1];
                } else {
                    $sql = "SELECT max(oca_id_obtencao_cargo) FROM oca_obtencao_cargo";
                    $idObteveCargo = proxId($con, $sql);
                    $sql = "INSERT INTO oca_obtencao_cargo (oca_id_obtencao_cargo, oca_des_obtencao_cargo) VALUES (?, ?)";
                    action($con, $sql, array(array($idObteveCargo, $obteveCargo)));
                }
            }

            // Temas existentes estaticamente no formulário
            $sql_tema = "SELECT * FROM tem_tema LIMIT 12";
            $stmt = $con->query($sql_tema);
            $row = $stmt->fetchAll();
            $temas = array();
            foreach ($row as $r) {
                //$temas[] = utf8_encode($r['tem_des_tema']);
                $temas[] = $r['tem_des_tema'];
            }
            //

            // Verificando os temas de formação selecionados p/ inserir/excluir
            $temaFormacao = value($p, 'cTemaFormacao');
            if (!$temaFormacao) $temaFormacao = array();
            $temaFormacaoOutro = value($p, 'ttfOutro');
            
            $data['i'] = array();
            $data['d'] = array();
            
            $sql_insert_tfo = "INSERT INTO tfo_tema_formacao (tfo_id_pesquisa_gestao, tfo_id_tema) VALUES (?, ?)";
            $sql_delete_tfo = "DELETE FROM tfo_tema_formacao WHERE tfo_id_pesquisa_gestao = ? AND tfo_id_tema = ?";
            $sql = "SELECT * FROM tfo_tema_formacao INNER JOIN tem_tema ON tfo_id_tema = tem_id_tema WHERE tfo_id_pesquisa_gestao = :id";
            
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            foreach ($row as $r)
            {
                //$tema = utf8_encode($r['tem_des_tema']);
                $tema = $r['tem_des_tema'];
                if (($idTemaFormacao = $r['tfo_id_tema']) <= 11)
                {
                    // Verifica se o dado presente no banco não está listado na atualização
                    // Caso afirmativo adiciona para exclusão, caso contrário, retira da lista de insert "$temaFormacao"
                    if (!in_array($tema, $temaFormacao))
                        $data['d'][] = array($id, $idTemaFormacao);
                    else
                        unset($temaFormacao[array_search($tema, $temaFormacao)]);
                }
                else
                {
                    // Verifica se o tema de formação "outro" é igual ao registrado
                    // Caso afirmativo retira da lista de inserção, caso contrário, adiciona para remoção do banco
                    if ($tema == $temaFormacaoOutro)
                        $temaFormacaoOutro = null;
                    else
                        $data['d'][] = array($id, $idTemaFormacao);
                }
            }
            
            foreach ($temaFormacao as $c)
            {
                if (is_int($idTema = array_search($c, $temas)))
                {
                    $data['i'][] = array($id, $idTema);
                }
                else
                {
                    // Verifica o tema "outro"
                    $sql_tem = "SELECT max(tem_id_tema) FROM tem_tema";
                    $sql_select_tem = "SELECT tem_id_tema, tem_des_tema FROM tem_tema WHERE tem_des_tema = ?";
                    if ($temaFormacaoOutro) {
                        if ($idOutro = existe($con, $sql_select_tem, array($temaFormacaoOutro))) {
                            $idOutro = $idOutro[1];
                        } else {
                            $idOutro = proxId($con, $sql_tem);
                            $sql = "INSERT INTO tem_tema (tem_id_tema, tem_des_tema) VALUES (?, ?)";
                            action($con, $sql, array(array($idOutro, $temaFormacaoOutro)));
                        }
                        $data['i'][] = array($id, $idOutro);
                    }
                }
            }
            // Aplica a ação insert
            action($con, $sql_insert_tfo, $data['i']);
            // Aplica a ação delete
            action($con, $sql_delete_tfo, $data['d']);
            //

            // Verificando se existe dados dos temas formação p/ inserir/excluir
            $temaFormacao = explode("; ", value($p, 'taTemaFormacaoDesenvolvimento'));
            if (!$temaFormacao) {
                $temaFormacao = array();
            }

            $temaFormacaoOutro = value($p, 'ttfdOutro');

            $data['i'] = array();
            $data['d'] = array();

            $sql_insert_tfd = "INSERT INTO tfd_tema_formacao_desenvolvimento (tfd_id_pesquisa_gestao, tfd_id_ordem_importancia, tfd_id_tema) VALUES (?, ?, ?)";
            $sql_delete_tfd = "DELETE FROM tfd_tema_formacao_desenvolvimento WHERE tfd_id_pesquisa_gestao = ? AND tfd_id_tema = ?";
            $sql = "SELECT * FROM tfd_tema_formacao_desenvolvimento INNER JOIN tem_tema ON tfd_id_tema = tem_id_tema WHERE tfd_id_pesquisa_gestao = :id";

            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            foreach ($row as $r)
            {
                //$tema = utf8_encode($r['tem_des_tema']);
                $tema = $r['tem_des_tema'];
                if (($idTemaFormacao = $r['tfd_id_tema']) <= 11) {
                    // Verifica se o dado presente no banco não está listado na atualização
                    // Caso afirmativo adiciona para exclusão, caso contrário, retira da lista de insert "$temaFormacao"
                    if (!in_array($tema, $temaFormacao)) {
                        $data['d'][] = array($id, $idTemaFormacao);
                    } else {
                        unset($temaFormacao[array_search($tema, $temaFormacao)]);
                    }

                } else {
                    // Verifica se o nome do tema "outro" é igual ao registrado
                    // Caso afirmativo retira da lista de inserção, caso contrário, adiciona para remoção do banco
                    if ($tema == $temaFormacaoOutro) {
                        $temaFormacaoOutro = null;
                    } else {
                        $data['d'][] = array($id, $idTemaFormacao);
                    }

                }
            }
            $sql_ordem = "SELECT max(tfd_id_ordem_importancia) FROM tfd_tema_formacao_desenvolvimento WHERE tfd_id_pesquisa_gestao = $id";
            $idOrdemTema = proxId($con, $sql_ordem);
            foreach ($temaFormacao as $c) {
                if (is_int($idTema = array_search($c, $temas))) {
                    $data['i'][] = array($id, $idOrdemTema, $idTema);
                } else {
                    // Verifica o tema "outro"
                    $sql_tem = "SELECT max(tem_id_tema) FROM tem_tema";
                    $sql_select_tem = "SELECT tem_id_tema, tem_des_tema FROM tem_tema WHERE tem_des_tema = ?";
                    if ($temaFormacaoOutro) {
                        if ($idOutro = existe($con, $sql_select_tem, array($temaFormacaoOutro))) {
                            $idOutro = $idOutro[1];
                        } else {
                            $idOutro = proxId($con, $sql_tem);
                            $sql = "INSERT INTO tem_tema (tem_id_tema, tem_des_tema) VALUES (?, ?)";
                            action($con, $sql, array(array($idOutro, $temaFormacaoOutro)));
                        }
                        $data['i'][] = array($id, $idOrdemTema, $idOutro);
                    }
                }
                $idOrdemTema += 1;
            }
            // Aplica a ação insert
            action($con, $sql_insert_tfd, $data['i']);
            // Aplica a ação delete
            action($con, $sql_delete_tfd, $data['d']);
            //

            // Verificando se deve ser inserido novo registro ou atualizado
            $sql_existe = "SELECT * FROM sog_sobre_gestao WHERE sog_id_pesquisa_gestao = ?";
            if (!existe($con, $sql_existe, array($id))) {
                $sql_action = "INSERT INTO sog_sobre_gestao (sog_id_pesquisa_gestao, sog_participou_curso, sog_temas_desenvolver_gestor, sog_justificativa_preparacao_formacao, sog_caracterizacao_bom_gestor, sog_id_preparacao_formacao, sog_id_obtencao_cargo) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $data = array(
                    $id,
                    $participouCurso,
                    value($p, 'taDesenvolverGestor'),
                    value($p, 'taJustificativaPreparacao'),
                    value($p, 'taCaracterizacaoBomGestor'),
                    value($p, 'rPreparouGestor'),
                    $idObteveCargo,
                );
            } else {
                $sql_action = "UPDATE sog_sobre_gestao SET sog_participou_curso = ?, sog_temas_desenvolver_gestor = ?, sog_justificativa_preparacao_formacao = ?, sog_caracterizacao_bom_gestor = ?, sog_id_preparacao_formacao = ?, sog_id_obtencao_cargo = ? WHERE sog_id_pesquisa_gestao = ?";
                $data = array(
                    $participouCurso,
                    value($p, 'taDesenvolverGestor'),
                    value($p, 'taJustificativaPreparacao'),
                    value($p, 'taCaracterizacaoBomGestor'),
                    value($p, 'rPreparouGestor'),
                    $idObteveCargo,
                    $id,
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
        header("Location: ../../form/perfil_escola.php");
    } else {
        echo "Falha durante a submissão.";
    }
} else {
    // Encaminha p/ próxima página caso a flag seja 0
    header("Location: ../../form/perfil_escola.php");
}
/**/
?>