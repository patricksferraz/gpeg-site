<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controller_adm/funs_adm.php';
require_once '../php/funs.php';
require_once '../php/controle_acesso/validar_adm.php';
require_once '../php/controller_write/cgeral.php';

$con = con_db_gpge();
$sql = "SELECT lac_data_acesso, usr_apelido, usr_nome, usr_email
    FROM lac_log_acesso INNER JOIN usr_usuario ON usr_id_usuario = lac_id_usuario
    ORDER BY lac_data_acesso DESC";
$log_acesso = actionSelect($con, $sql);

$sql = "SELECT lmp_data_envio, lmp_enviado, des_nome_escola, usr_apelido
    FROM lmp_log_mensagem_pesquisa INNER JOIN pge_pesquisa_gestao
    ON pge_id_pesquisa_gestao = lmp_id_pesquisa_gestao INNER JOIN des_dados_escola
    ON des_id_escola = pge_id_escola INNER JOIN usr_usuario
    ON usr_id_usuario = lmp_id_usuario_enviou
    ORDER BY lmp_data_envio DESC";
$log_mensagem = actionSelect($con, $sql);

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
                <h4 class="col-xs-6 text-left"><a href="adm/historico.php" class="yellow-gpge-text">Histórico</a> <a href="adm/gerenciador_pesquisa.php" class="small yellow-gpge-text">Gerenciador de pesquisa</a> <a href="adm/gerenciador_evento.php" class="small yellow-gpge-text">Gerenciador de evento</a></h4>
                <h5 class="col-xs-6 text-right">usuário: <strong><?php echo $_SESSION['apelido'] ?></strong></h5>
            </div>
        </blockquote>

        <div class='container-fluid'>

            <div class="row">
                <div class="form-group col-xs-6 text-left">
                    <button type="button" onclick="tabelaLog(0)" class="btn btn-warning btn-sm">
                    Log de acesso
                    </button>
                    <button type="button" onclick="tabelaLog(1)" class="btn btn-warning btn-sm">
                    Log de mensagem
                    </button>
                </div>
            </div>

            <div class='row'>
                <!--Panel Principal da Tabela Ações-->
                <div id='tabelaLogAcesso' class="col-md-12">
                    <!-- <div class="row">
                        <div class="form-group col-xs-12 text-right">
                            <button type="button" onClick="$('#tableExportLogAcesso').tableExport({type: 'excel', escape: 'false'});" class="btn btn-danger btn-xs">
                                Exportar Excel
                            </button>
                            <button type="button" onClick="$('#tableExportLogAcesso').tableExport({type: 'csv', escape: 'false'});" class="btn btn-danger btn-xs">
                                Exportar CSV
                            </button>
                        </div>
                    </div> -->
                    <!--Tabela Responsiva-->
                    <div class='table-responsive'>
                        <table id="tableExportLogAcesso" class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Usuário</th>
                                    <th>E-mail</th>
                                    <th>Data de acesso</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($log_acesso as $l) {
                                echo "<tr style='cursor: hand'>"
                                ."<td><strong>" . (++$i) . "</strong></td>"
                                ."<td>" . $l[2] . "</td>"
                                ."<td>" . $l[1] . "</td>"
                                ."<td>" . $l[3] . "</td>"
                                ."<td>" . date_format(date_create($l[0]), 'd/m/Y H:i:s') . "</td></tr>";
                            }
                            
                            ?>
                            </tbody>
                        </table>

                    </div><!--Fim Tabela Responsiva-->
                </div>
                
                <div id='tabelaLogMensagem' class="col-md-12">
                    <!-- <div class="row">
                        <div class="form-group col-xs-12 text-right">
                            <button type="button" onClick="$('#tableExportLogMensagem').tableExport({type: 'excel', escape: 'false'});" class="btn btn-danger btn-xs">
                                Exportar Excel
                            </button>
                            <button type="button" onClick="$('#tableExportLogMensagem').tableExport({type: 'csv', escape: 'false'});" class="btn btn-danger btn-xs">
                                Exportar CSV
                            </button>
                        </div>
                    </div> -->
                    <!--Tabela Responsiva-->
                    <div class='table-responsive'>
                        <table id="tableExportLogMensagem" class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Escola</th>
                                    <th>Usuário que enviou</th>
                                    <th>Enviada com sucesso?</th>
                                    <th>Data do envio</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($log_mensagem as $l) {
                                echo "<tr style='cursor: hand'>"
                                ."<td><strong>" . (++$i) . "</strong></td>"
                                ."<td>" . $l[2] . "</td>"
                                ."<td>" . $l[3] . "</td>"
                                ."<td>" . ($l[1] ? "Sim" : "Não") . "</td>"
                                ."<td>" . date_format(date_create($l[0]), 'd/m/Y H:i:s') . "</td></tr>";
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