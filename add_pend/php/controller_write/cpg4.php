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
            // Verifica se possui acessibilidade e insere/altera os dados
            $possuiAcessibilidade = value($p, 'rAcessibilidade');
            $sql_existe = "SELECT * FROM aes_acessibilidade_escola WHERE aes_id_pesquisa_gestao = ?";
            if (!existe($con, $sql_existe, array($id)))
            {
                $sql_action = "INSERT INTO aes_acessibilidade_escola (aes_id_pesquisa_gestao, aes_des_acessibilidade) VALUES (?, ?)";
                if ($possuiAcessibilidade)
                    $data = array(
                        $id,
                        value($p, 'taEstruturaAcessibilidade')
                    );
                else
                    $data = array(
                        $id,
                        null
                    );
            }
            else
            {
                $sql_action = "UPDATE aes_acessibilidade_escola SET aes_des_acessibilidade = ? WHERE aes_id_pesquisa_gestao = ?";
                if ($possuiAcessibilidade)
                    $data = array(
                        value($p, 'taEstruturaAcessibilidade'),
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

            // Verifica se a escola abre aos finais de semana e insere/altera os dados
            $abreFinalSemana = value($p, 'rAbreFinalSemana');
            $sql_existe = "SELECT * FROM ffd_funciona_final_semana WHERE ffd_id_pesquisa_gestao = ?";
            if (!existe($con, $sql_existe, array($id)))
            {
                $sql_action = "INSERT INTO ffd_funciona_final_semana (ffd_id_pesquisa_gestao, ffd_sabado_m, ffd_sabado_t, ffd_sabado_n, ffd_domingo_m, ffd_domingo_t, ffd_domingo_n) VALUES (?, ?, ?, ?, ?, ?, ?)";
                if ($abreFinalSemana)
                    $data = array(
                        $id,
                        value($p, 'cAbreSabadoM'),
                        value($p, 'cAbreSabadoT'),
                        value($p, 'cAbreSabadoN'),
                        value($p, 'cAbreDomingoM'),
                        value($p, 'cAbreDomingoT'),
                        value($p, 'cAbreDomingoN')
                    );
                else
                    $data = array(
                        $id,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null
                    );
            }
            else
            {
                $sql_action = "UPDATE ffd_funciona_final_semana SET ffd_sabado_m = ?, ffd_sabado_t = ?, ffd_sabado_n = ?, ffd_domingo_m = ?, ffd_domingo_t = ?, ffd_domingo_n = ? WHERE ffd_id_pesquisa_gestao = ?";
                if ($abreFinalSemana)
                    $data = array(
                        value($p, 'cAbreSabadoM'),
                        value($p, 'cAbreSabadoT'),
                        value($p, 'cAbreSabadoN'),
                        value($p, 'cAbreDomingoM'),
                        value($p, 'cAbreDomingoT'),
                        value($p, 'cAbreDomingoN'),
                        $id
                    );
                else
                    $data = array(
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        $id
                    );
            }
            // Aplica a ação
            action($con, $sql_action, array($data));
            //

            // Verificando se existe dados dos cursos existentes na escola p/ inserir/excluir
            $cursoEscola = value($p, 'cCursoEscola');
            if (!$cursoEscola) $cursoEscola = array();
            $cursoOutro = value($p, 'tCursoOutros');
            
            $data['i'] = array();
            $data['d'] = array();
            
            $sql_insert_ces = "INSERT INTO ces_curso_escola (ces_id_pesquisa_gestao, ces_id_curso) VALUES (?, ?)";
            $sql_delete_ces = "DELETE FROM ces_curso_escola WHERE ces_id_pesquisa_gestao = ? AND ces_id_curso = ?";
            $sql = "SELECT * FROM ces_curso_escola INNER JOIN cur_curso ON ces_id_curso = cur_id_curso WHERE ces_id_pesquisa_gestao = :id";
            
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            foreach ($row as $r)
            {
                if (($idCurso = $r['ces_id_curso']) <= 1)
                {
                    // Verifica se o dado presente no banco não está listado na atualização
                    // Caso afirmativo adiciona para exclusão, caso contrário, retira da lista de insert "$cursoEscola"
                    if (!in_array($idCurso, $cursoEscola))
                        $data['d'][] = array($id, $idCurso);
                    else
                        unset($cursoEscola[array_search($idCurso, $cursoEscola)]);
                }
                else
                {
                    // Verifica se o nome do curso "outro" é igual ao registrado
                    // Caso afirmativo retira da lista de inserção, caso contrário, adiciona para remoção do banco
                    if (in_array("O", $cursoEscola) && $r['cur_des_curso'] == $cursoOutro)
                        unset($cursoEscola[array_search("O", $cursoEscola)]);
                    else
                        $data['d'][] = array($id, $idCurso);
                }
            }
            foreach ($cursoEscola as $c)
            {
                if($c != "O")
                    $data['i'][] = array($id, $c);
                else
                {
                    // Verifica o curso "outro"
                    $sql_cur = "SELECT max(cur_id_curso) FROM cur_curso";
                    $sql_select_cur = "SELECT cur_id_curso, cur_des_curso FROM cur_curso WHERE cur_des_curso = ?";
                    if ($cursoOutro)
                    {
                        if($idOutro = existe($con, $sql_select_cur, array($cursoOutro)))
                            $idOutro = $idOutro[1];
                        else
                        {
                            $idOutro = proxId($con, $sql_cur);
                            $sql = "INSERT INTO cur_curso (cur_id_curso, cur_des_curso) VALUES (?, ?)";
                            action($con, $sql, array(array($idOutro, $cursoOutro)));
                        }
                        $data['i'][] = array($id, $idOutro);
                    }
                }
            }
            // Aplica a ação insert
            action($con, $sql_insert_ces, $data['i']);
            // Aplica a ação delete
            action($con, $sql_delete_ces, $data['d']);
            //

            // Verifica se possui dados sobre os cargos existentes na escola e insere/altera os dados
            $sql_existe = "SELECT * FROM cae_cargo_escola WHERE cae_id_pesquisa_gestao = ? AND cae_des_cargo = ?";
            $sql_insert_cae = "INSERT INTO cae_cargo_escola (cae_id_pesquisa_gestao, cae_des_cargo, cae_qnt, cae_id_satisfacao) VALUES (?, ?, ?, ?)";
            $sql_update_cae = "UPDATE cae_cargo_escola SET cae_qnt = ?, cae_id_satisfacao = ? WHERE cae_id_pesquisa_gestao = ? AND cae_des_cargo = ?";
            $data['i'] = array();
            $data['u'] = array();

            if (!($nVD = value($p, 'nViceDiretor'))) $nVD = null;
            if (!($nCP = value($p, 'nCoordenadorPedagogico'))) $nCP = null;
            if (!($nOE = value($p, 'nOrientadorEducacional'))) $nOE = null;
            if (!($nPC = value($p, 'nProfessorContratado'))) $nPC = null;
            if (!($nPE = value($p, 'nProfessorEfetivo'))) $nPE = null;
            if (!($nAA = value($p, 'nArticuladorArea'))) $nAA = null;
            if (!($nS = value($p, 'nSecretaria'))) $nS = null;
            if (!($nAS = value($p, 'nAuxiliarSecretaria'))) $nAS = null;
            if (!($nM = value($p, 'nMerendeira'))) $nM = null;
            if (!($nP = value($p, 'nPorteiro'))) $nP = null;
            if (!($nL = value($p, 'nLimpeza'))) $nL = null;
            if (!($nO = value($p, 'nOutro'))) $nO = null;
            // CARGO ESCOLA, QNT E AVALIAÇÃO
            $outro = value($p, 'tOutraFuncao');
            $taOutro = value($p, 'taOutraFuncao');

            // Deletando Outro anterior do BD para posterior inserção do novo
            if ($taOutro && ($outro != $taOutro))
            {
                $sql_delete_cae = "DELETE FROM cae_cargo_escola WHERE cae_id_pesquisa_gestao = ? AND cae_des_cargo = ?";
                action($con, $sql_delete_cae, array(array($id, $taOutro)));
            }

            $cargoEscola = array(
                array('Vice-diretor', $nVD, value($p, 'rSViceDiretor')),
                array('Coordenador pedagógico', $nCP, value($p, 'rSCoordenadorPedagogico')),
                array('Orientador educacional', $nOE, value($p, 'rSOrientadorEducacional')),
                array('Professor contratado', $nPC, value($p, 'rSProfessorContratado')),
                array('Professor efetivo', $nPE, value($p, 'rSProfessorEfetivo')),
                array('Articulador de área', $nAA, value($p, 'rSArticuladorArea')),
                array('Secretária', $nS, value($p, 'rSSecretaria')),
                array('Auxiliar de secretaria', $nAS, value($p, 'rSAuxiliarSecretaria')),
                array('Merendeira', $nM, value($p, 'rSMerendeira')),
                array('Porteiro', $nP, value($p, 'rSPorteiro')),
                array('Limpeza', $nL, value($p, 'rSLimpeza')),
                array($outro, $nO, value($p, 'rSOutro'))
            );
            foreach ($cargoEscola as $n)
            {
                if (!existe($con, $sql_existe, array($id, $n[0])) && ($n[1] || $n[2]))
                    $data['i'][] = array(
                        $id,
                        $n[0],
                        $n[1],
                        $n[2]
                    );
                else
                    $data['u'][] = array(
                        $n[1],
                        $n[2],
                        $id,
                        $n[0]
                    );
            }
            // Aplica a ação insert
            action($con, $sql_insert_cae, $data['i']);
            // Aplica a ação update
            action($con, $sql_update_cae, $data['u']);
            //

            if (!($qtAluno = value($p, 'nQntAluno'))) {
                $qtAluno = null;
            }
            // Verificando se deve ser inserido novo registro ou atualizado
            $sql_existe = "SELECT * FROM pee_perfil_escola WHERE pee_id_pesquisa_gestao = ?";
            if (!existe($con, $sql_existe, array($id)))
            {
                $sql_action = "INSERT INTO pee_perfil_escola (pee_id_pesquisa_gestao, pee_turno_escolar_M, pee_turno_escolar_V, pee_turno_escolar_N, pee_possui_acessibilidade, pee_qnt_alunos, pee_abre_final_semana, pee_id_estrutura_escola) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $data = array(
                    $id,
                    value($p, 'cTurnoEscolaM'),
                    value($p, 'cTurnoEscolaV'),
                    value($p, 'cTurnoEscolaN'),
                    $possuiAcessibilidade,
                    $qtAluno,
                    $abreFinalSemana,
                    value($p, 'rEstruturaEscola')
                );
            }
            else
            {
                $sql_action = "UPDATE pee_perfil_escola SET pee_turno_escolar_M = ?, pee_turno_escolar_V = ?, pee_turno_escolar_N = ?, pee_possui_acessibilidade = ?, pee_qnt_alunos = ?, pee_abre_final_semana = ?, pee_id_estrutura_escola = ? WHERE pee_id_pesquisa_gestao = ?";
                $data = array(
                    value($p, 'cTurnoEscolaM'),
                    value($p, 'cTurnoEscolaV'),
                    value($p, 'cTurnoEscolaN'),
                    $possuiAcessibilidade,
                    $qtAluno,
                    $abreFinalSemana,
                    value($p, 'rEstruturaEscola'),
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
        header("Location: ../../form/gestao_escola.php"); 
    }
    else
    {
        echo "Falha durante a submissão.";
    }
}
else
{
    // Encaminha p/ próxima página caso a flag seja 0
    header("Location: ../../form/gestao_escola.php");
}
/**/

?>