<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controle_acesso/validar_adm.php';
require_once '../php/controller_write/cgeral.php';

$con = con_db_gpge();
$sql = "SELECT pge_id_pesquisa_gestao AS 'Id pesquisa gestão',
       des_nome_escola AS 'Nome escola',
       GROUP_CONCAT(nfo_des_nivel_formacao ORDER BY pge_id_pesquisa_gestao, ', ') AS 'Grau formação gestor',
       GROUP_CONCAT(fge_des_formacao ORDER BY pge_id_pesquisa_gestao, ', ') AS 'Formação',
       peg_genero AS 'Gênero gestor',
       fet_des_faixa_etaria AS 'Faixa etária gestor',
       CASE peg_exerceu_gestao_antes
           WHEN 0 THEN 'Não'
           WHEN 1 THEN 'Sim'
       END AS 'Exerceu gestão antes?',
       res_des_rede_escola AS 'Rede escolar anterior',
       peg_gestor_qnts_vezes AS 'Por quantas vezes foi gestor antes?',
       peg_ch_semanal_gestao AS 'CH semanal para o desenvolvimento das funções do gestor?',
       oca_des_obtencao_cargo AS 'Como obteve o cargo?',
       CASE sog_participou_curso
           WHEN 0 THEN 'Não'
           WHEN 1 THEN 'Sim'
       END AS 'Participou de algum curso de gestão com mais de 40h?',
       cge_quantidade_curso AS 'Quantidade de cursos que participou',
       cge_quando_ultimo AS 'Ano do último curso',
       ccu_des_colaboracao_curso AS 'Esse(s) curso(s) colaborou para formação?',
       pfo_des_preparacao_formacao AS 'O curso de graduação/licenciatura preparou para gestão?',
       CASE pee_turno_escolar_M
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Funciona no turno matutino?',
       CASE pee_turno_escolar_V
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Funciona no turno vespertino?',
       CASE pee_turno_escolar_N
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Funciona no turno noturno?',
       pee_qnt_alunos AS 'Quantidade de aluno',
       ees_des_estrutura_escola AS 'Estrutura da escola',
       CASE pee_possui_acessibilidade
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Possui acessibilidade?',
       CASE pee_abre_final_semana
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Abre finais de semana?',
       CASE oge_avaliacao_interna
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Existe algum instrumento de avaliação da sua gestão?',
       oge_importancia_diretor AS '0 a 10, importancia do gestor para aprendizagem dos alunos'
  FROM db_gpge.pge_pesquisa_gestao INNER JOIN db_gpge.des_dados_escola
    ON des_id_escola = pge_id_escola LEFT JOIN db_gpge.fge_formacao_gestor
    ON fge_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.nfo_nivel_formacao
    ON nfo_id_nivel_formacao = fge_id_nivel_formacao LEFT JOIN db_gpge.peg_perfil_gestor
    ON peg_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.fet_faixa_etaria
    ON fet_id_faixa_etaria = peg_id_faixa_etaria LEFT JOIN db_gpge.res_rede_escola
    ON res_id_rede_escola = peg_id_rede_escola_antes LEFT JOIN  db_gpge.sog_sobre_gestao
    ON sog_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.oca_obtencao_cargo
    ON oca_id_obtencao_cargo = sog_id_obtencao_cargo LEFT JOIN db_gpge.cge_curso_gestao
    ON cge_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.ccu_colaboracao_curso
    ON ccu_id_colaboracao_curso = cge_id_colaboracao_curso LEFT JOIN db_gpge.pfo_preparacao_formacao
    ON pfo_id_prepacao_formacao = sog_id_preparacao_formacao LEFT JOIN db_gpge.pee_perfil_escola
    ON pee_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.ees_estrutura_escola
    ON ees_id_estrutura_escola = pee_id_estrutura_escola LEFT JOIN db_gpge.oge_organizacao_gestao_escola
    ON oge_id_pesquisa_gestao = pge_id_pesquisa_gestao
    WHERE pge_data_ultima_alteracao IS NOT NULL
    GROUP BY pge_id_pesquisa_gestao, des_nome_escola, peg_genero, fet_des_faixa_etaria,
         peg_exerceu_gestao_antes, res_des_rede_escola, peg_gestor_qnts_vezes, peg_ch_semanal_gestao,
         oca_des_obtencao_cargo, sog_participou_curso, cge_quantidade_curso, cge_quando_ultimo,
         ccu_des_colaboracao_curso, pfo_des_preparacao_formacao, pee_turno_escolar_M, pee_turno_escolar_V,
         pee_turno_escolar_N, pee_qnt_alunos, ees_des_estrutura_escola, pee_possui_acessibilidade,
         pee_abre_final_semana, oge_avaliacao_interna, oge_importancia_diretor";
$data = actionSelect($con, $sql);
$con = null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once '../include/head.php'; ?>
    <title>GPEG - Janela Administrativa</title>
</head>
<body>

    <?php require_once '../include/header.php'; ?>

    <div class="container margin-bottom">
        <br>
        <blockquote>
            <div class="row">
                <h4 class="col-xs-6 text-left"><a href="adm/gerenciador_pesquisa.php" class="yellow-gpge-text">Results</a></h4>
                <h5 class="col-xs-6 text-right">usuário: <strong><?php echo $_SESSION['apelido'] ?></strong></h5>
            </div>
        </blockquote>

        <div class='container-fluid'>

            <div class='row'>
                <!--Panel Principal da Tabela Ações-->
                <div class="col-md-12">
                    <!--Tabela Responsiva-->
                    <div class='table-responsive'>
                        <div class="row">
                            <h5 class="col-xs-12 col-md-6 text-left" id="relatorio"></h5>
                            <div class="form-group col-xs-6 text-right">
                                <button type="button" onClick="$('#tableExportResults').tableExport({type: 'excel', escape: 'false'});" class="btn btn-danger btn-xs">
                                    Exportar Excel
                                </button>
                                <button type="button" onClick="$('#tableExportResults').tableExport({type: 'csv', escape: 'false'});" class="btn btn-danger btn-xs">
                                    Exportar CSV
                                </button>
                            </div>
                        </div>
                        <table id="tableExportResults" class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>Id pesquisa gestão</th>
                                    <th>Nome escola</th>
                                    <th>Grau formação gestor</th>
                                    <th>Formação</th>
                                    <th>Gênero gestor</th>
                                    <th>Faixa etária gestor</th>
                                    <th>Exerceu gestão antes?</th>
                                    <th>Rede escolar anterior</th>
                                    <th>Por quantas vezes foi gestor antes?</th>
                                    <th>CH semanal para o desenvolvimento das funções do gestor?</th>
                                    <th>Como obteve o cargo?</th>
                                    <th>Participou de algum curso de gestão com mais de 40h?</th>
                                    <th>Quantidade de cursos que participou</th>
                                    <th>Ano do último curso</th>
                                    <th>Esse(s) curso(s) colaborou para formação?</th>
                                    <th>O curso de graduação/licenciatura preparou para gestão?</th>
                                    <th>Funciona no turno matutino?</th>
                                    <th>Funciona no turno vespertino?</th>
                                    <th>Funciona no turno noturno?</th>
                                    <th>Quantidade de aluno</th>
                                    <th>Estrutura da escola</th>
                                    <th>Possui acessibilidade?</th>
                                    <th>Abre finais de semana?</th>
                                    <th>Existe algum instrumento de avaliação da sua gestao?</th>
                                    <th>0 a 10, importancia do gestor para aprendizagem dos alunos</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($data as $d) {
                                echo "<tr style='cursor: hand'>"
                                ."<td>" . $d[0] . "</td>"
                                ."<td>" . $d[1] . "</td>"
                                ."<td>" . $d[2] . "</td>"
                                ."<td>" . $d[3] . "</td>"
                                ."<td>" . $d[4] . "</td>"
                                ."<td>" . $d[5] . "</td>"
                                ."<td>" . $d[6] . "</td>"
                                ."<td>" . $d[7] . "</td>"
                                ."<td>" . $d[8] . "</td>"
                                ."<td>" . $d[9] . "</td>"
                                ."<td>" . $d[10] . "</td>"
                                ."<td>" . $d[11] . "</td>"
                                ."<td>" . $d[12] . "</td>"
                                ."<td>" . $d[13] . "</td>"
                                ."<td>" . $d[14] . "</td>"
                                ."<td>" . $d[15] . "</td>"
                                ."<td>" . $d[16] . "</td>"
                                ."<td>" . $d[17] . "</td>"
                                ."<td>" . $d[18] . "</td>"
                                ."<td>" . $d[19] . "</td>"
                                ."<td>" . $d[20] . "</td>"
                                ."<td>" . $d[21] . "</td>"
                                ."<td>" . $d[22] . "</td>"
                                ."<td>" . $d[23] . "</td>"
                                ."<td>" . $d[24] . "</td></tr>";
                            }

                            ?>
                            </tbody>
                        </table>

                    </div><!--Fim Tabela Responsiva-->
                </div><!--Fim Panel Principal da Tabela de Ações-->
            </div>

        </div>

    </div>

    <?php require_once '../include/footer.php'; ?>

</body>
</html>
