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
            /**
             * Sql para consulta de dados existentes
             * capturar proxima id e
             * inserir novo registro na tebela de tempo
             */
            $sql_tge = "SELECT tge_id_tempo_gestao FROM tge_tempo_gestao WHERE tge_anos = ? AND tge_meses = ?";
            $sql_tge_proxid = "SELECT max(tge_id_tempo_gestao) FROM tge_tempo_gestao";
            $sql_tge_insert = "INSERT INTO tge_tempo_gestao (tge_id_tempo_gestao, tge_anos, tge_meses) VALUES (?, ?, ?)";
            /**/

            // Verificando insert ou select de tempo de gestão existente
            // Período de gestão atual
            if (!($tempoGestaoAtualAno = value($p, 'nTempoGestaoAtualAno'))) {
                $tempoGestaoAtualAno = null;
            }

            if (!($tempoGestaoAtualMes = value($p, 'nTempoGestaoAtualMes'))) {
                $tempoGestaoAtualMes = null;
            }

            if ($tempoGestaoAtualAno || $tempoGestaoAtualMes) {
                if ($tempoGestaoAtual = existe($con, $sql_tge, array($tempoGestaoAtualAno, $tempoGestaoAtualMes))) {
                    $tempoGestaoAtual = $tempoGestaoAtual[1];
                } else {
                    $tempoGestaoAtual = proxId($con, $sql_tge_proxid);
                    action($con, $sql_tge_insert, array(array($tempoGestaoAtual, $tempoGestaoAtualAno, $tempoGestaoAtualMes)));
                }
            } else {
                $tempoGestaoAtual = null;
            }

            //

            // Validando dados para preenchimento dos campos dependente do radio
            $exerceuGestaoAntes = value($p, 'rGestorAntes');
            if ($exerceuGestaoAntes) {
                // Verificando insert ou select de tempo de gestão existente
                // Período de gestão anterior
                if (!($tempoGestaoAntesAno = value($p, 'nTempoGestaoAntesAno'))) {
                    $tempoGestaoAntesAno = null;
                }

                if (!($tempoGestaoAntesMes = value($p, 'nTempoGestaoAntesMes'))) {
                    $tempoGestaoAntesMes = null;
                }

                if ($tempoGestaoAntesAno || $tempoGestaoAntesMes) {
                    if ($tempoGestaoAntes = existe($con, $sql_tge, array($tempoGestaoAntesAno, $tempoGestaoAntesMes))) {
                        $tempoGestaoAntes = $tempoGestaoAntes[1];
                    } else {
                        $tempoGestaoAntes = proxId($con, $sql_tge_proxid);
                        action($con, $sql_tge_insert, array(array($tempoGestaoAntes, $tempoGestaoAntesAno, $tempoGestaoAntesMes)));
                    }
                } else {
                    $tempoGestaoAntes = null;
                }

                //
                $redeEscola = value($p, 'rRedeEscola');
                if (!($qntVezesGestor = value($p, 'nGestorQntVezes'))) {
                    $qntVezesGestor = null;
                }
            } else {
                $tempoGestaoAntes = null;
                $redeEscola = null;
                $qntVezesGestor = null;
            }
            //

            if (!($chSemanal = value($p, 'nChSemanalGestao'))) {
                $chSemanal = null;
            }

            // Verificando se deve ser inserido novo registro ou atualizado
            $sql_existe = "SELECT * FROM peg_perfil_gestor WHERE peg_id_pesquisa_gestao = ?";
            if (!existe($con, $sql_existe, array($id))) {
                $sql = "INSERT INTO peg_perfil_gestor (peg_id_pesquisa_gestao, peg_genero, peg_exerceu_gestao_antes, peg_gestor_qnts_vezes, peg_ch_semanal_gestao, peg_id_faixa_etaria, peg_id_tempo_gestao_atual, peg_id_tempo_gestao_antes, peg_id_rede_escola_antes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $data = array(
                    $id,
                    value($p, 'rSexo'),
                    $exerceuGestaoAntes,
                    $qntVezesGestor,
                    $chSemanal,
                    value($p, 'rIdade'),
                    $tempoGestaoAtual,
                    $tempoGestaoAntes,
                    $redeEscola,
                );
                var_dump($data);
            } else {
                $sql = "UPDATE peg_perfil_gestor SET peg_genero = ?, peg_exerceu_gestao_antes = ?, peg_gestor_qnts_vezes = ?, peg_ch_semanal_gestao = ?, peg_id_faixa_etaria = ?, peg_id_tempo_gestao_atual = ?, peg_id_tempo_gestao_antes = ?, peg_id_rede_escola_antes = ? WHERE peg_id_pesquisa_gestao = ?";
                $data = array(
                    value($p, 'rSexo'),
                    $exerceuGestaoAntes,
                    $qntVezesGestor,
                    $chSemanal,
                    value($p, 'rIdade'),
                    $tempoGestaoAtual,
                    $tempoGestaoAntes,
                    $redeEscola,
                    $id,
                );
            }
            // Inserindo/Atualizando registro no banco de dados
            action($con, $sql, array($data));
            //

            // Registra a data da última alteração do formulário
            registraUltimaAlteracao($con, $id);

            echo "Submissão realizada com sucesso.";
        }

        // Encerra conexão e encaminha para próxima página
        $con = null;
        header("Location: ../../form/gestao.php");

    } else {
        echo "Falha durante a submissão.";
    }
} else {
    // Encaminha p/ próxima página caso a flag seja 0
    header("Location: ../../form/gestao.php");
}
/**/
?>