<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controle_acesso/validar_sessao.php';
require_once '../php/controller_read/cpg5.php';
require_once '../php/funs.php';

$con = con_db_gpge();
$id = $_SESSION['id'];
$data['ferramenta'] = array();
$data['ideb'] = array();
$data['conselho'] = array();
$data['agente'] = array();
$data = data_pg5($con, $id);
$con = null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once '../include/head.php'; ?>
    <title>GPEG - Formulário (Organização e gestão da escola)</title>
</head>
<body>

    <?php require_once '../include/header.php'; ?>

    <div class="container margin-bottom">

        <div class='container-fluid'>

            <form action="php/controller_write/cpg5.php" method="POST" accept-charset="utf-8">
                <br>
                <div class="row">
                    <h4 class="col-md-6 text-left">Questionário dirigido ao gestor da escola</h4>
                    <h5 class="col-md-6 text-right">Página 5 de 5</h5>
                </div>

                <div class="row">
                    <blockquote>
                        <h4>V - Sobre a Organização e Gestão da Escola</h4>
                    </blockquote>
                </div>

                <input type="hidden" id="tid" name="tid" value="<?php echo $id ?>" readonly>
                <input type="hidden" id="flag" name="flag" value="0" readonly>
                
                <div class="row">

                    <div class="form-group col-md-12">
                        <label for="taCompetenciasDiretor">Do seu ponto de vista. Quais são as competências de um gestor escolar?</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taCompetenciasDiretor" name="taCompetenciasDiretor"><?php echo value($data, 'competencias_diretor'); ?></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="taAcompanhamentoPedagogico">Como é a sua atuação no acompanhamento pedagógico da escola?</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taAcompanhamentoPedagogico" name="taAcompanhamentoPedagogico"><?php echo value($data, 'acompanhamento_pedagogico'); ?></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="taAcoesPedagogicas">Liste até 3 ações que são desenvolvidas no acompanhamento pedagógico na escola:</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taAcoesPedagogicas" name="taAcoesPedagogicas"><?php echo value($data, 'acoes_pedagogicas'); ?></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="taAcoesAdministrativas">Liste até 3 ações que são desenvolvidas no acompanhamento administrativo na escola.</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taAcoesAdministrativas" name="taAcoesAdministrativas"><?php echo value($data, 'acoes_administrativas'); ?></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="taPrincipaisProblemas">Quais os principais problema que você enfrenta na gestão da escola?</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taPrincipaisProblemas" name="taPrincipaisProblemas"><?php echo value($data, 'principais_problemas'); ?></textarea>
                    </div>

                    <label class="col-md-12">Existe algum instrumento de avaliação da sua gestão?</label>
                    <div class="form-group col-md-12">
                        <label class="radio-inline">
                            <input type="radio" name="rAvaliacaoInterna" value="1" <?php if (value($data, 'avaliacao_interna') == '1') echo 'checked';?>> Sim
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rAvaliacaoInterna" value="0" <?php if (value($data, 'avaliacao_interna') == '0') echo 'checked';?>> Não
                        </label>
                    </div>
                    <div class="form-group col-md-12 rAvaliacaoInterna">
                        <label for="taQuaisAvaliacoes">Qual(is)?</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taQuaisAvaliacoes" name="taQuaisAvaliacoes"><?php echo value($data, 'quais_avaliacoes');?></textarea>
                    </div>

                    <label class="col-md-12">Na sua escola tem:</label>
                    <div class="form-group col-md-12">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cConselhosExistentes[]" value="0" <?php if(value($data['conselho'], '0')) echo 'checked';?>>
                            Colegiado escolar
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cConselhosExistentes[]" value="1" <?php if(value($data['conselho'], '1')) echo 'checked';?>>
                            Associação de Pais e Mestres
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cConselhosExistentes[]" value="O" onclick="checkOculto(this, 'cConselhosExistentes')" <?php if($conselhoOutro = value($data['conselho'], 'O')) echo 'checked';?>>
                            Outros<span class="cConselhosExistentes">: Quais?</span>
                            <input type="text" class="form-control col-md-12 cConselhosExistentes" maxlength="100" name="tConselhosOutros" value="<?php echo $conselhoOutro;?>">
                        </label>
                    </div>

                    <label class="col-md-12">Em uma escala de 0 a 10, qual a importância do gestor para aprendizagem dos alunos?</label>
                    <div class="form-group col-md-2">
                        <input type="number" min="0" max="10" id="nImportanciaDiretor" name="nImportanciaDiretor" class="form-control" id="nImportanciaDiretor" name="nImportanciaDiretor" value="<?php echo value($data, 'importancia_diretor');?>">
                    </div>
                    <div class="row"></div>

                    <div class="col-md-12">
                        <label for="">A maioria das escolas ficou abaixo da nota 6,00 na Prova Brasil. Assinale, por ordem de importância, os responsáveis por tal desempenho:</label>
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-bordered">
                                <tbody>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Aluno</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Aluno" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '0')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Família</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Família" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '1')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Direção escolar</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Direção escolar" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '2')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Professor</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Professor" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '3')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Coordenador pedagógico</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Coordenador pedagógico" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '4')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Governo</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Governo" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '5')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Projeto pedagógico da escola</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Projeto pedagógico da escola" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '6')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Merenda escolar</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Merenda escolar" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '7')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Bolsa família</th>
                                        <td><input type="checkbox" name="cBaixoRendimento[]" value="Bolsa família" onclick="checkImportancia(this, 'taBaixoRendimento')" <?php if(value($data['agente'], '8')) echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Outros: <span class="cBaixoRendimento">especifique</span></th>
                                        <td>
                                            <input type="checkbox" name="cBaixoRendimento[]" value="O" onclick="checkOcultoText(this, 'tbrOutro', 'cBaixoRendimento')" <?php if($baixoRendimento = value($data['agente'], 'O')) echo 'checked';?>>
                                            <input type="text" class="form-control col-md-12 cBaixoRendimento" maxlength="100" id="tbrOutro" name="tbrOutro" onchange="checkImportanciaOutro(this, 'tbroAnterior', 'taBaixoRendimento')" value="<?php echo $baixoRendimento;?>">
                                            <input type="hidden" class="form-control col-md-12" id="tbroAnterior" name="tbroAnterior" value="<?php echo $baixoRendimento;?>" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <h6>Ordem de importância:</h6>
                        <textarea class="form-control" id="taBaixoRendimento" name="taBaixoRendimento" readonly><?php echo value($data, 'tBaixoRendimento');?></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Qual a nota da sua escola no IDEB nas últimas duas avaliações?</label>
                        <div class="input-group col-md-3">
                            <div class="input-group-addon">2015</div>
                            <input type="number" step="1" min="0" max="10" class="form-control" id="nNotaIdeb2015" name="nNotaIdeb2015" value="<?php echo value($data['ideb'], '2015');?>">
                        </div>
                        <div class="input-group col-md-3">
                            <div class="input-group-addon">2016</div>
                            <input type="number" step="1" min="0" max="10" class="form-control" id="nNotaIdeb2016" name="nNotaIdeb2016" value="<?php echo value($data['ideb'], '2016');?>">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="taEstrategiaMelhoriaIdeb">Quais as estratégias criadas pela gestão da escola para intervir nesses resultados?</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taEstrategiaMelhoriaIdeb" name="taEstrategiaMelhoriaIdeb"><?php echo value($data, 'melhoria_ideb');?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 text-left">
                            <button type="button" onclick="location.href = 'form/perfil_escola.php'" class="btn btn-lg btn-warning">Voltar</button>
                        </div>
                        <div class="col-xs-6 text-right">
                            <button type="submit" class="btn btn-lg btn-warning">Próxima</button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <?php require_once '../include/footer.php'; ?>
    <script>noSubmitEnter()</script>

</body>
</html>