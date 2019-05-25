<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controle_acesso/validar_sessao.php';
require_once '../php/controller_read/cpg3.php';
require_once '../php/funs.php';

$con = con_db_gpge();
$id = $_SESSION['id'];
$data['temaFormacao'] = array();
$data['temaFormacaoDesenvolvimento'] = array();
$data = data_pg3($con, $id);
$con = null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once '../include/head.php'; ?>
    <title>GPEG - Formulário (Gestão)</title>
</head>
<body>

    <?php require_once '../include/header.php'; ?>

    <div class="container margin-bottom">

        <div class='container-fluid'>

            <form action="php/controller_write/cpg3.php" method="POST" accept-charset="utf-8">
                <br>
                <div class="row">
                    <h4 class="col-md-6 text-left">Questionário dirigido ao gestor da escola</h4>
                    <h5 class="col-md-6 text-right">Página 3 de 5</h5>
                </div>

                <div class="row">
                    <blockquote>
                        <h4>III - Sobre a Gestão</h4>
                    </blockquote>
                </div>

                <input type="hidden" id="tid" name="tid" value="<?php echo $id ?>" readonly>
                <input type="hidden" id="flag" name="flag" value="0" readonly>

                <div class="row">
                    
                    <label class="col-md-12">Como você chegou ao cargo de gestor desta escola?</label>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rObteveCargo" value="0" <?php if (value($data, 'id_obtencao_cargo') == '0') echo 'checked';?>>
                            Concurso Público
                        </label>
                    </div>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rObteveCargo" value="1" <?php if (value($data, 'id_obtencao_cargo') == '1') echo 'checked';?>>
                            Eleição Direta
                        </label>
                    </div>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rObteveCargo" value="2" <?php if (value($data, 'id_obtencao_cargo') == '2') echo 'checked';?>>
                            Seleção Técnica
                        </label>
                    </div>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rObteveCargo" value="3" <?php if (value($data, 'id_obtencao_cargo') == '3') echo 'checked';?>>
                            Indicação Política
                        </label>
                    </div>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rObteveCargo" value="O" <?php if (value($data, 'id_obtencao_cargo') > '3') echo 'checked';?>>
                            Outros<span class="rObteveCargo">. Quais?</span>
                            <input type="text" class="form-control col-md-12 rObteveCargo" maxlength="50" id="tObteveCargo" name="tObteveCargo" value="<?php if (value($data, 'id_obtencao_cargo') > 3) echo value($data, 'obtencao_cargo');?>">
                        </label>
                    </div>

                    <label class="col-md-12" >Você já participou de algum curso de gestão escolar com mais de 40h?</label>
                    <div class="form-group col-md-12">
                        <label class="radio-inline">
                            <input type="radio" name="rCursoGestao" value="1" <?php if (value($data, 'participou_curso') == '1') echo 'checked';?>> Sim
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rCursoGestao" value="0" <?php if (value($data, 'participou_curso') == '0') echo 'checked';?>> Não
                        </label>
                    </div>
                    <div class="rCursoGestao">
                        <div class="col-md-3">
                            <label for="">Quantos cursos você participou?</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="0" max="999" class="form-control" id="nQntCurso" name="nQntCurso" value="<?php echo value($data, 'qnt_curso');?>">
                                    <div class="input-group-addon">curso(s)</div>
                                </div>
                            </div>
                        </div>
                        <!--VERIFICAR-->
                        <div class="form-group col-md-3">
                            <label for="nQuandoUltimoCurso">Quando foi o último? (ano)</label>
                            <input type="number" min="<?php echo date('Y')-100;?>" max="<?php echo date('Y');?>" class="form-control" maxlength="500" id="nQuandoUltimoCurso" name="nQuandoUltimoCurso" value="<?php echo value($data, 'quando_ultimo_curso');?>">
                        </div>
                        <!---->
                        <div class="form-group col-md-6">
                            <label for="tQualUltimoCurso">Qual foi o último?</label>
                            <input type="text" class="form-control" maxlength="500" id="tQualUltimoCurso" name="tQualUltimoCurso" value="<?php echo value($data, 'qual_ultimo_curso');?>">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Qual(is) o(s) tema(s) abordado(s)?</label>
                            <textarea rows="3" class="form-control" maxlength="500" id="taTemaAbordado" name="taTemaAbordado"><?php echo value($data, 'tema_abordado');?></textarea>
                        </div>
    
                        <label class="col-md-12">Sobre esse(s) curso(s) você diria que:</label>
                        <div class="radio col-md-12">
                            <label>
                                <input type="radio" name="rColaboracaoCurso" value="N" <?php if (value($data, 'colaboracao') == 'N') echo 'checked';?>>
                                <strong>Não colaboraram</strong> para melhorar a minha gestão na escola
                            </label>
                        </div>
                        <div class="radio col-md-12">
                            <label>
                                <input type="radio" name="rColaboracaoCurso" value="P" <?php if (value($data, 'colaboracao') == 'P') echo 'checked';?>>
                                <strong>Colaboraram pouco</strong> para melhorar a minha gestão na escola
                            </label>
                        </div>
                        <div class="radio col-md-12">
                            <label>
                                <input type="radio" name="rColaboracaoCurso" value="C" <?php if (value($data, 'colaboracao') == 'C') echo 'checked';?>>
                                <strong>Colaboraram</strong> para melhorar a minha gestão na escola
                            </label>
                        </div>
                        <div class="radio col-md-12">
                            <label>
                                <input type="radio" name="rColaboracaoCurso" value="M" <?php if (value($data, 'colaboracao') == 'M') echo 'checked';?>>
                                <strong>Colaboraram muito</strong> para melhorar a minha gestão na escola
                            </label>
                        </div>
                    </div>

                    <label class="col-md-12">Quais dos temas abaixo você já recebeu formação? (Pode marcar mais de um)</label>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Liderança" <?php if(value($data['temaFormacao'], '0')) echo 'checked';?>>
                                Liderança
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Projeto político pedagógico" <?php if(value($data['temaFormacao'], '1')) echo 'checked';?>>
                                Projeto político pedagógico
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Políticas públicas" <?php if(value($data['temaFormacao'], '2')) echo 'checked';?>>
                                Políticas públicas
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Organizações da aprendizagem" <?php if(value($data['temaFormacao'], '3')) echo 'checked';?>>
                                Organizações da aprendizagem
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Tecnologias e aprendizagem" <?php if(value($data['temaFormacao'], '4')) echo 'checked';?>>
                                Tecnologias e aprendizagem
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Financiamento" <?php if(value($data['temaFormacao'], '5')) echo 'checked';?>>
                                Financiamento
                            </label>
                        </div>
                    </div>
                    <!---->
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Finanças" <?php if(value($data['temaFormacao'], '6')) echo 'checked';?>>
                                Finanças
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Trabalho em equipe" <?php if(value($data['temaFormacao'], '7')) echo 'checked';?>>
                                Trabalho em equipe
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Noções de administração e legislação" <?php if(value($data['temaFormacao'], '8')) echo 'checked';?>>
                                Noções de administração e legislação
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Cidadania e sustentabilidade" <?php if(value($data['temaFormacao'], '9')) echo 'checked';?>>
                                Cidadania e sustentabilidade
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Gestão participativa e democrática" <?php if(value($data['temaFormacao'], '10')) echo 'checked';?>>
                                Gestão participativa e democrática
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento')" value="Prestação de contas" <?php if(value($data['temaFormacao'], '11')) echo 'checked';?>>
                                Prestação de contas
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cTemaFormacao[]" value="O" onclick="checkTema(this, 'cTemaFormacaoDesenvolvimento[]', 'taTemaFormacaoDesenvolvimento');checkOcultoText(this, 'ttfOutro', 'cTemaFormacao')" <?php if($temaFormacao = value($data['temaFormacao'], 'O')) echo 'checked';?>>
                                Outros<span class="cTemaFormacao"> (especificar)</span>
                                <input type="text" class="form-control col-md-12 cTemaFormacao" maxlength="100" id="ttfOutro" name="ttfOutro" onchange="checkTemaOutro(this, 'ttfdOutro', 'ctfdOutro', 'taTemaFormacaoDesenvolvimento')" value="<?php echo $temaFormacao;?>">
                            </label>
                        </div>
                    </div>

                    <label class="col-md-12">Dos temas que você assinalou, marque, por ordem de importancia, aquelas que mais contribuem/contribuíram para suas ações como gestor:</label>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Liderança" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '0')) echo 'checked';?>>
                                Liderança
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Projeto político pedagógico" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '1')) echo 'checked';?>>
                                Projeto político pedagógico
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Políticas públicas" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '2')) echo 'checked';?>>
                                Políticas públicas
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Organizações da aprendizagem" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '3')) echo 'checked';?>>
                                Organizações da aprendizagem
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Tecnologias e aprendizagem" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '4')) echo 'checked';?>>
                                Tecnologias e aprendizagem
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Financiamento" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '5')) echo 'checked';?>>
                                Financiamento
                            </label>
                        </div>
                    </div>
                    <!---->
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Finanças" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '6')) echo 'checked';?>>
                                Finanças
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Trabalho em equipe" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '7')) echo 'checked';?>>
                                Trabalho em equipe
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Noções de administração e legislação" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '8')) echo 'checked';?>>
                                Noções de administração e legislação
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Cidadania e sustentabilidade" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '9')) echo 'checked';?>>
                                Cidadania e sustentabilidade
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Gestão participativa e democrática" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '10')) echo 'checked';?>>
                                Gestão participativa e democrática
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" value="Prestação de contas" onclick="checkImportancia(this, 'taTemaFormacaoDesenvolvimento')" <?php if(value($data['temaFormacaoDesenvolvimento'], '11')) echo 'checked';?>>
                                Prestação de contas
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="oculto">
                                <input type="checkbox" name="cTemaFormacaoDesenvolvimento[]" id="ctfdOutro" value="O" onclick="checkImportanciaAlt(this, 'ttfdOutro', 'taTemaFormacaoDesenvolvimento')" <?php if($temaFormacaoDesenvolvimento = value($data['temaFormacaoDesenvolvimento'], 'O')) echo 'checked';?> disabled>
                                Outros
                                <input type="text" class="form-control col-md-12" id="ttfdOutro" name="ttfdOutro" value="<?php echo $temaFormacaoDesenvolvimento;?>" readonly>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <h6>Ordem de importância:</h6>
                        <textarea class="form-control" rows="2" id="taTemaFormacaoDesenvolvimento" name="taTemaFormacaoDesenvolvimento" readonly><?php echo value($data, 'tTemaFormacaoDesenvolvimento');?></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="taDesenvolverGestor">Sobre quais temas você gostaria de estudar para melhor desenvolver as ações de gestor?</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taDesenvolverGestor" name="taDesenvolverGestor"><?php echo value($data, 'temas_desenvolver');?></textarea>
                    </div>

                    <label class="col-md-12">O curso de Graduação/Licenciatura lhe preparou para ser gestor escolar?</label>
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="rPreparouGestor" value="0" <?php if (value($data, 'preparacao_curso') == '0') echo 'checked';?>>
                                Não preparou
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="rPreparouGestor" value="1" <?php if (value($data, 'preparacao_curso') == '1') echo 'checked';?>>
                                Preparou pouco
                            </label>
                        </div>
                    </div>
                    <!---->
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="rPreparouGestor" value="2" <?php if (value($data, 'preparacao_curso') == '2') echo 'checked';?>>
                                Preparou
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="rPreparouGestor" value="3" <?php if (value($data, 'preparacao_curso') == '3') echo 'checked';?>>
                                Preparou muito
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="taJustificativaPreparacao">Por quê?</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taJustificativaPreparacao" name="taJustificativaPreparacao"><?php echo value($data, 'justificativa_preparacao');?></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="taCaracterizacaoBomGestor">Para você o que caracteriza um bom gestor escolar?</label>
                        <textarea rows="3" class="form-control" maxlength="1000" id="taCaracterizacaoBomGestor" name="taCaracterizacaoBomGestor"><?php echo value($data, 'caracterizacao');?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 text-left">
                            <button type="button" onclick="location.href = 'form/perfil_gestor.php'" class="btn btn-lg btn-warning">Voltar</button>
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