<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controller_adm/funs_adm.php';
require_once '../php/funs.php';
require_once '../php/controle_acesso/validar_adm.php';

$con = con_db_gpge();
$data = selectPesquisa($con);
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

    <!-- Modal Gerador Pesquisa-->
    <div class="modal fade" id="geradorPesquisa" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="formGerador" action="php/controller_adm/gerador_pesquisa.php" method="POST" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Gerador de pesquisa</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="alert" class="alert alert-danger col-md-12" role="alert">
                            </div>
                            <div class="form-group col-md-12 conteudoForm">
                                <label for="dPeriodoInicial" class="control-label">Período inicial:</label>
                                <input name="dPeriodoInicial" id="dPeriodoInicial" type="date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-12 conteudoForm">
                                <label for="dPeriodoFinal" class="control-label">Período final:</label>
                                <input name="dPeriodoFinal" id="dPeriodoFinal" type="date" class="form-control" required>
                            </div>    
                        </div>
                    </div>
                    <div class="modal-footer conteudoForm">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="validarPesquisa();" class="btn btn-primary">Gerar pesquisa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!---->

    <!-- Modal Lembrete Pesquisa-->
    <div class="modal fade" id="enviarMensagem" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form  accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Envio de mensagem</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="alertMensagem" class="alert alert-danger col-md-12" role="alert">
                            </div>
                            <input id="hIdUsuario" name="hIdUsuario" type="hidden" value="<?php echo $_SESSION['id_usuario'] ?>" readonly/>
                            <div class="form-group col-md-12">
                                <label for="sDestinatario" class="control-label">Enviar para:</label>
                                <select class="form-control" id="sDestinatario" name="sDestinatario">
                                    <option value="0">Todos</option>
                                    <option value="1">Submetidos</option>
                                    <option value="2">Em edição</option>
                                    <option value="3">Pendentes</option>
                                    <option value="4" id="destClick"></option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="tAssunto" class="control-label">Assunto:</label>
                                <input id="tAssunto" name="tAssunto" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="taMensagem" class="control-label">Mensagem:</label>
                                <textarea id="taMensagem" name="taMensagem" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="cLembrete" name="cLembrete" value="1"> Enviar lembrete de pesquisa
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer conteudoFormMensagem">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="enviarMensagem()" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!---->

    <div class="container margin-bottom">
        <br>
        <blockquote>
            <div class="row">
                <h4 class="col-xs-6 text-left"><a href="adm/gerenciador_pesquisa.php" class="yellow-gpge-text">Gerenciador de pesquisa</a> <a href="adm/gerenciador_evento.php" class="small yellow-gpge-text">Gerenciador de evento</a> <a href="adm/historico.php" class="small yellow-gpge-text">Histórico</a></h4>
                <h5 class="col-xs-6 text-right">usuário: <strong><?php echo $_SESSION['apelido'] ?></strong></h5>
            </div>
        </blockquote>

        <div class='container-fluid'>

            <div class="row">
                <h4 class="col-md-12">Selecione a pesquisa que deseja analisar</h4>
            </div>

            <div class="row">
                <!-- Button trigger modal Enviar mensagem -->
                <div class="form-group col-xs-6 text-left">
                    <button id="buttonMensagem" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#enviarMensagem">
                    Enviar mensagem
                    </button>
                </div>
                <!-- Button trigger modal Gerador pesquisa -->
                <div class="form-group col-xs-6 text-right">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#geradorPesquisa">
                    Gerar nova pesquisa
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="">Período da pesquisa:</label>
                    <select name="periodoPesquisa" id="periodoPesquisa" class="form-control" onchange="selectPesquisa()">
                        <option value=""></option>
                        <?php
                        if ($data)
                            foreach ($data as $d)
                                echo "<option value='$d[0]'>".date_format(date_create($d[1]), 'd/m/Y')." - ".date_format(date_create($d[2]), 'd/m/Y')."</option>";
                        ?>
                    </select>
                </div>
            </div>

            <div class='row'>
                <!--Panel Principal da Tabela Ações-->
                <div id='tabelaPesquisa' class="col-md-12">
                    <!--Tabela Responsiva-->
                    <div class="row">
                        <h5 class="col-xs-12 col-md-6 text-left" id="relatorio"></h5>
                        <div class="form-group col-xs-6 text-right">
                            <button type="button" onClick="$('#tableExportPesquisa').tableExport({type: 'excel', escape: 'false'});" class="btn btn-danger btn-xs">
                                Exportar Excel
                            </button>
                            <button type="button" onClick="$('#tableExportPesquisa').tableExport({type: 'csv', escape: 'false'});" class="btn btn-danger btn-xs">
                                Exportar CSV
                            </button>
                        </div>
                    </div>
                    <div class='table-responsive'>
                        <table id="tableExportPesquisa" class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome escola</th>
                                    <th>Município</th>
                                    <th>E-mail</th>
                                    <th>Última alteração</th>
                                    <th>Situação</th>
                                    <th>Pesquisa</th>
                                    <th>Código Acesso</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTabelaPesquisa">
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