<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controller_adm/funs_adm.php';
require_once '../php/funs.php';
require_once '../php/controle_acesso/validar_adm.php';

$con = con_db_gpge();
$data = selectEvento($con);
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

        <!-- Modal -->
        <div class="modal fade" id="modalInscrito" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <blockquote>
                            <h4 class="modal-title"><span id="mNome_completo"></span><br>(<span id="mNome_cracha"></span>)</h4>
                            <span class="small" id="mFormacao"></span>
                            <b><span class="small" id="mEscola"></span></b>
                        </blockquote>
                    </div>
                    <div class="modal-body">
                        <h5><b>Respondeu a pesquisa:</b> <span id="mRespondeu_pesquisa"></span></h5>
                        <h5><b>Temas/Cursos que gostaria de participar:</b></h5>
                        <h5 id="mTemas">
                        </h5>
                        
                        <hr>
                        <h5><b>Contato:</b></h5>
                        <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                         <span id="mTelefone"></span>
                        <br>
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                         <span id="mEmail"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODAL -->

        <br>
        <blockquote>
            <div class="row">
                <h4 class="col-xs-6 text-left"><a href="adm/gerenciador_evento.php" class="yellow-gpge-text">Gerenciador de evento</a> <a href="adm/gerenciador_pesquisa.php"class="small yellow-gpge-text">Gerenciador de pesquisa</a> <a href="adm/historico.php" class="small yellow-gpge-text">Histórico</a></h4>
                <h5 class="col-xs-6 text-right">usuário: <strong><?php echo $_SESSION['apelido'] ?></strong></h5>
            </div>
        </blockquote>

        <div class='container-fluid'>

            <div class="row">
                <h4 class="col-md-12">Selecione o evento que deseja analisar</h4>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="">Evento:</label>
                    <select name="evento" id="evento" class="form-control" onchange="selectEvento()">
                        <option value=""></option>
                        <?php
                        if ($data)
                            foreach ($data as $d)
                                echo "<option value='$d[0]'>".date_format(date_create($d[1]), 'd/m/Y')." - $d[2]</option>";
                        ?>
                    </select>
                </div>
            </div>

            <div class='row'>
                <!--Panel Principal da Tabela Ações-->
                <div id='tabelaEvento' class="col-md-12">
                    <div class="row">
                        <h5 class="col-xs-12 col-md-6 text-left" id="relatorio"></h5>
                        <div class="form-group col-xs-6 text-right">
                            <button type="button" onClick="$('#tableExportEvento').tableExport({type: 'excel', escape: 'false'});" class="btn btn-danger btn-xs">
                                Exportar Excel
                            </button>
                            <button type="button" onClick="$('#tableExportEvento').tableExport({type: 'csv', escape: 'false'});" class="btn btn-danger btn-xs">
                                Exportar CSV
                            </button>
                        </div>
                    </div>
                    <!--Tabela Responsiva-->
                    <div class='table-responsive'>
                        <table id="tableExportEvento" class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome participante</th>
                                    <th>Nome crachá</th>
                                    <th>Escola</th>
                                    <th>Município</th>
                                    <th>Respondeu a pesquisa?</th>
                                    <th>Data da inscrição</th>
                                    <th>Dados</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTabelaEvento">
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