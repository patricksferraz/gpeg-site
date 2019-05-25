<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controle_acesso/validar_sessao.php';
require_once '../php/controller_read/cpg4.php';
require_once '../php/funs.php';

$con = con_db_gpge();
$id = $_SESSION['id'];
$data['cursoEscola'] = array();
$data['cargo'] = array();
$data = data_pg4($con, $id);
$con = null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once '../include/head.php'; ?>
    <title>GPEG - Formulário (Perfil da escola)</title>
</head>
<body>

    <?php require_once '../include/header.php'; ?>

    <div class="container margin-bottom">

        <div class='container-fluid'>

            <form action="php/controller_write/cpg4.php" method="POST" accept-charset="utf-8">
                <br>
                <div class="row">
                    <h4 class="col-md-6 text-left">Questionário dirigido ao gestor da escola</h4>
                    <h5 class="col-md-6 text-right">Página 4 de 5</h5>
                </div>

                <div class="row">
                    <blockquote>
                        <h4>IV - Sobre o Perfil da Escola</h4>
                    </blockquote>
                </div>

                <input type="hidden" id="tid" name="tid" value="<?php echo $id ?>" readonly>
                <input type="hidden" id="flag" name="flag" value="0" readonly>

                <div class="row">

                    <label class="col-md-12">A escola funciona nos turnos:</label>
                    <div class="form-group col-md-12">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cTurnoEscolaM" value="1" <?php if (value($data, 'turno_m') == '1') echo 'checked';?>> Matutino
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cTurnoEscolaV" value="1" <?php if (value($data, 'turno_v') == '1') echo 'checked';?>> Vespertino
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cTurnoEscolaN" value="1" <?php if (value($data, 'turno_n') == '1') echo 'checked';?>> Noturno
                        </label>
                    </div>

                    <label class="col-md-12">A escola funciona com os cursos:</label>
                    <div class="form-group col-md-12">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cCursoEscola[]" value="0" <?php if(value($data['cursoEscola'], '0')) echo 'checked';?>>
                            Ensino médio
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cCursoEscola[]" value="1" <?php if(value($data['cursoEscola'], '1')) echo 'checked';?>>
                            curso profissionalizante
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cCursoEscola[]" value="O" onclick="checkOculto(this, 'cCursoEscola')" <?php if($cursoEscola = value($data['cursoEscola'], 'O')) echo 'checked';?>>
                            Outros<span class="cCursoEscola">, cite o(s) curso(s):</span>
                            <input type="text" class="form-control col-md-12 cCursoEscola" name="tCursoOutros" value="<?php echo $cursoEscola;?>">
                        </label>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="nQntAluno">Quantos alunos tem na escola?</label>
                        <div class="input-group col-md-3">
                            <input type="number" min="0" class="form-control" id="nQntAluno" name="nQntAluno" value="<?php echo value($data, 'qnt_aluno');?>">
                            <div class="input-group-addon">alunos</div>
                        </div>
                    </div>

                    <label class="col-md-12">A escola possui:</label>
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="rEstruturaEscola" value="P" <?php if (value($data, 'estrutura_escola') == 'P') echo 'checked';?>>
                                péssima estrutura física
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="rEstruturaEscola" value="R" <?php if (value($data, 'estrutura_escola') == 'R') echo 'checked';?>>
                                razoável estrutura física
                            </label>
                        </div>
                    </div>
                    <!---->
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="rEstruturaEscola" value="B" <?php if (value($data, 'estrutura_escola') == 'B') echo 'checked';?>>
                                boa estrutura física
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="rEstruturaEscola" value="O" <?php if (value($data, 'estrutura_escola') == 'O') echo 'checked';?>>
                                ótima estrutura física
                            </label>
                        </div>
                    </div>

                    <label class="col-md-12">A escola tem acessibilidade?</label>
                    <div class="form-group col-md-12">
                        <label class="radio-inline">
                            <input type="radio" name="rAcessibilidade" value="1" <?php if (value($data, 'possui_acessibilidade') == '1') echo 'checked';?>> Sim
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rAcessibilidade" value="0" <?php if (value($data, 'possui_acessibilidade') == '0') echo 'checked';?>> Não
                        </label>
                    </div>
                    <div class="form-group col-md-12 rAcessibilidade">
                        <label for="taEstruturaAcessibilidade">Indique a estrutura de acessibilidade existente</label>
                        <textarea rows="3" class="form-control" id="taEstruturaAcessibilidade" name="taEstruturaAcessibilidade"><?php echo value($data, 'des_acessibilidade');?></textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="">Das funções abaixo, marque as existentes em sua escola e faça uma avaliação delas:</label>
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-bordered">
                                <thead>
                                    <tr class="tr-nocenter-first">
                                        <th rowspan="2" scope="col" class="col-md-4">Funções</th>
                                        <th rowspan="2" scope="col" class="col-md-1">Quantos</th>
                                        <th colspan="5" scope="col" class="col-md-7">
                                            Grau de satisfação<br>
                                            <small>Muito insatisfeito(<span class="text-danger">MI</span>) | Insatisfeito(<span class="text-danger">I</span>) | Neutro(<span class="text-danger">N</span>) | Satisfeito(<span class="text-danger">S</span>) | Muito satisfeito(<span class="text-danger">MS</span>)</small>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col">MI</th>
                                        <th scope="col">I</th>
                                        <th scope="col">N</th>
                                        <th scope="col">S</th>
                                        <th scope="col">MS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Vice-diretor</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nViceDiretor" value="<?php $v = value($data['cargo'], 'Vice-diretor'); echo value($v, '0'); unset($data['cargo']['Vice-diretor']);?>"></td>
                                        <td><input type="radio" name="rSViceDiretor" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSViceDiretor" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSViceDiretor" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSViceDiretor" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSViceDiretor" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Coordenador pedagógico</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nCoordenadorPedagogico" value="<?php $v = value($data['cargo'], 'Coordenador pedagógico'); echo value($v, '0'); unset($data['cargo']['Coordenador pedagógico']);?>"></td>
                                        <td><input type="radio" name="rSCoordenadorPedagogico" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSCoordenadorPedagogico" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSCoordenadorPedagogico" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSCoordenadorPedagogico" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSCoordenadorPedagogico" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Orientador educacional</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nOrientadorEducacional" value="<?php $v = value($data['cargo'], 'Orientador educacional'); echo value($v, '0'); unset($data['cargo']['Orientador educacional']);?>"></td>
                                        <td><input type="radio" name="rSOrientadorEducacional" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSOrientadorEducacional" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSOrientadorEducacional" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSOrientadorEducacional" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSOrientadorEducacional" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Professor contratado</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nProfessorContratado" value="<?php $v = value($data['cargo'], 'Professor contratado'); echo value($v, '0'); unset($data['cargo']['Professor contratado']);?>"></td>
                                        <td><input type="radio" name="rSProfessorContratado" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSProfessorContratado" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSProfessorContratado" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSProfessorContratado" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSProfessorContratado" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Professor efetivo</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nProfessorEfetivo" value="<?php $v = value($data['cargo'], 'Professor efetivo'); echo value($v, '0'); unset($data['cargo']['Professor efetivo']);?>"></td>
                                        <td><input type="radio" name="rSProfessorEfetivo" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSProfessorEfetivo" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSProfessorEfetivo" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSProfessorEfetivo" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSProfessorEfetivo" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Articulador de área</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nArticuladorArea" value="<?php $v = value($data['cargo'], 'Articulador de área'); echo value($v, '0'); unset($data['cargo']['Articulador de área']);?>"></td>
                                        <td><input type="radio" name="rSArticuladorArea" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSArticuladorArea" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSArticuladorArea" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSArticuladorArea" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSArticuladorArea" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Secretária</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nSecretaria" value="<?php $v = value($data['cargo'], 'Secretária'); echo value($v, '0'); unset($data['cargo']['Secretária']);?>"></td>
                                        <td><input type="radio" name="rSSecretaria" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSSecretaria" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSSecretaria" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSSecretaria" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSSecretaria" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Auxiliar de secretaria</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nAuxiliarSecretaria" value="<?php $v = value($data['cargo'], 'Auxiliar de secretaria'); echo value($v, '0'); unset($data['cargo']['Auxiliar de secretaria']);?>"></td>
                                        <td><input type="radio" name="rSAuxiliarSecretaria" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSAuxiliarSecretaria" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSAuxiliarSecretaria" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSAuxiliarSecretaria" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSAuxiliarSecretaria" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Merendeira</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nMerendeira" value="<?php $v = value($data['cargo'], 'Merendeira'); echo value($v, '0'); unset($data['cargo']['Merendeira']);?>"></td>
                                        <td><input type="radio" name="rSMerendeira" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSMerendeira" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSMerendeira" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSMerendeira" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSMerendeira" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Porteiro</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nPorteiro" value="<?php $v = value($data['cargo'], 'Porteiro'); echo value($v, '0'); unset($data['cargo']['Porteiro']);?>"></td>
                                        <td><input type="radio" name="rSPorteiro" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSPorteiro" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSPorteiro" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSPorteiro" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSPorteiro" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Limpeza (terceirizado ou não)</th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nLimpeza" value="<?php $v = value($data['cargo'], 'Limpeza'); echo value($v, '0'); unset($data['cargo']['Limpeza']);?>"></td>
                                        <td><input type="radio" name="rSLimpeza" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSLimpeza" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSLimpeza" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSLimpeza" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSLimpeza" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                    <tr class="tr-nocenter-first">
                                        <th scope="row">Outro função:
                                            <input type="text" maxlength="50" class="form-control" name="tOutraFuncao" value="<?php $k = key($data['cargo']); $v = value($data['cargo'], $k); echo $k;?>">
                                            <input type="hidden" class="form-control" name="taOutraFuncao" value="<?php echo $k; ?>" readonly>
                                        </th>
                                        <td><input type="number" min="0" max="999" class="form-control" name="nOutro" value="<?php echo value($v, '0');?>"></td>
                                        <td><input type="radio" name="rSOutro" value="MI" <?php if(value($v, '1') == 'MI') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSOutro" value="I" <?php if(value($v, '1') == 'I') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSOutro" value="N" <?php if(value($v, '1') == 'N') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSOutro" value="S" <?php if(value($v, '1') == 'S') echo 'checked';?>></td>
                                        <td><input type="radio" name="rSOutro" value="MS" <?php if(value($v, '1') == 'MS') echo 'checked';?>></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <label class="col-md-12">A escola abre aos finais de semana para a comunidade?</label>
                    <div class="form-group col-md-12">
                        <label class="radio-inline">
                            <input type="radio" name="rAbreFinalSemana" value="1" <?php if (value($data, 'abre_final_semana') == '1') echo 'checked';?>> Sim
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rAbreFinalSemana" value="0" <?php if (value($data, 'abre_final_semana') == '0') echo 'checked';?>> Não
                        </label>
                    </div>
                    <div class="rAbreFinalSemana">
                        <label class="col-md-12">Sábado:</label>
                        <div class="form-group col-md-12">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="cAbreSabadoM" value="1" <?php if (value($data, 'sabado_m') == '1') echo 'checked';?>> Manhã
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="cAbreSabadoT" value="1" <?php if (value($data, 'sabado_t') == '1') echo 'checked';?>> Tarde
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="cAbreSabadoN" value="1" <?php if (value($data, 'sabado_n') == '1') echo 'checked';?>> Noite
                            </label>
                        </div>

                        <label class="col-md-12">Domingo:</label>
                        <div class="form-group col-md-12">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="cAbreDomingoM" value="1" <?php if (value($data, 'domingo_m') == '1') echo 'checked';?>> Manhã
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="cAbreDomingoT" value="1" <?php if (value($data, 'domingo_t') == '1') echo 'checked';?>> Tarde
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="cAbreDomingoN" value="1" <?php if (value($data, 'domingo_n') == '1') echo 'checked';?>> Noite
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 text-left">
                            <button type="button" onclick="location.href = 'form/gestao.php'" class="btn btn-lg btn-warning">Voltar</button>
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