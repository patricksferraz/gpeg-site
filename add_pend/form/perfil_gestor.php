<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controle_acesso/validar_sessao.php';
require_once '../php/controller_read/cpg2.php';
require_once '../php/funs.php';

$con = con_db_gpge();
$id = $_SESSION['id'];
$data = data_pg2($con, $id);
$con = null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once '../include/head.php'; ?>
    <title>GPEG - Formulário (Perfil do gestor)</title>
</head>
<body>

    <?php require_once '../include/header.php'; ?>

    <div class="container margin-bottom">

        <div class='container-fluid'>

            <form action="php/controller_write/cpg2.php" method="POST" accept-charset="utf-8">
                <br>
                <div class="row">
                    <h4 class="col-md-6 text-left">Questionário dirigido ao gestor da escola</h4>
                    <h5 class="col-md-6 text-right">Página 2 de 5</h5>
                </div>

                <div class="row">
                    <blockquote>
                        <h4>II - Sobre o Perfil do Gestor (Diretor)</h4>
                    </blockquote>
                </div>

                <input type="hidden" id="tid" name="tid" value="<?php echo $id ?>" readonly>
                <input type="hidden" id="flag" name="flag" value="0" readonly>

                <div class="row">

                    <label class="col-md-12" >Gênero:</label>
                    <div class="form-group col-md-12">
                        <label class="radio-inline">
                            <input type="radio" name="rSexo" id="masculino" value="M" <?php if (value($data, 'genero') == 'M') echo 'checked'; ?>> Masculino
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rSexo" id="feminino" value="F" <?php if (value($data, 'genero') == 'F') echo 'checked'; ?>> Feminino
                        </label>
                    </div>

                    <label class="col-md-12">Qual a sua faixa de idade?</label>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rIdade" value="0" <?php if (value($data, 'faixa_etaria') == '0') echo 'checked'; ?>>
                            Até 30 anos
                        </label>
                    </div>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rIdade" value="1" <?php if (value($data, 'faixa_etaria') == '1') echo 'checked'; ?>>
                            31 a 40 anos
                        </label>
                    </div>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rIdade" value="2" <?php if (value($data, 'faixa_etaria') == '2') echo 'checked'; ?>>
                            41 a 50 anos
                        </label>
                    </div>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rIdade" value="3" <?php if (value($data, 'faixa_etaria') == '3') echo 'checked'; ?>>
                            51 a 60 anos
                        </label>
                    </div>
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="rIdade" value="4" <?php if (value($data, 'faixa_etaria') == '4') echo 'checked'; ?>>
                            Mais de 60 anos
                        </label>
                    </div>

                    <label class="col-md-12">Há quanto tempo você é Gestor desta escola?</label>
                    <div class="form-inline col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" class="form-control" min="0" id="nTempoGestaoAtualAno" name="nTempoGestaoAtualAno" value="<?php echo value($data, 'tempo_gestao_atual_anos'); ?>">
                                <div class="input-group-addon">anos</div>
                            </div>
                        </div> e
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" class="form-control" min="0" id="nTempoGestaoAtualMes" name="nTempoGestaoAtualMes" value="<?php echo value($data, 'tempo_gestao_atual_meses'); ?>">
                                <div class="input-group-addon">meses</div>
                            </div>
                        </div>
                    </div>

                    <label class="col-md-12"><br>Já exerceu a função de Gestor escolar antes?</label>
                    <div class="form-group col-md-12">
                        <label class="radio-inline">
                            <input type="radio" name="rGestorAntes" value="1" <?php if (value($data, 'exerceu_gestao') == '1') echo 'checked'; ?>> Sim
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rGestorAntes" value="0" <?php if (value($data, 'exerceu_gestao') == '0') echo 'checked'; ?>> Não
                        </label>
                    </div>

                    <div class="rGestorAntes">
                        <label class="col-md-12">Por quanto tempo?</label>
                        <div class="form-inline col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" min="0" id="nTempoGestaoAntesAno" name="nTempoGestaoAntesAno" value="<?php echo value($data, 'tempo_gestao_antes_anos'); ?>">
                                    <div class="input-group-addon">anos</div>
                                </div>
                            </div> e
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" min="0" id="nTempoGestaoAntesMes" name="nTempoGestaoAntesMes" value="<?php echo value($data, 'tempo_gestao_antes_meses'); ?>">
                                    <div class="input-group-addon">meses</div>
                                </div>
                            </div>
                        </div>

                        <label class="col-md-12"><br>A Escola era da Rede:</label>
                        <div class="form-group col-md-12">
                            <label class="radio-inline">
                                <input type="radio" name="rRedeEscola" value="M" <?php if (value($data, 'rede_escola') == 'M') echo 'checked'; ?>> Municipal
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="rRedeEscola" value="E" <?php if (value($data, 'rede_escola') == 'E') echo 'checked'; ?>> Estadual
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="rRedeEscola" value="A" <?php if (value($data, 'rede_escola') == 'A') echo 'checked'; ?>> Municipal e Estadual
                            </label>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="nGestorQntVezes">Por quantas vezes você já exerceu essa função antes?</label>
                            <div class="input-group col-md-3">
                                <input type="number" min="0" class="form-control" id="nGestorQntVezes" name="nGestorQntVezes" value="<?php echo value($data, 'vezes_gestor'); ?>">
                                <div class="input-group-addon">vezes</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Qual a carga horária semanal para o desenvolvimento das funções do Gestor?</label>
                        <div class="input-group col-md-3">
                            <input type="number" min="0" class="form-control" id="nChSemanalGestao" name="nChSemanalGestao" value="<?php echo value($data, 'ch_gestor'); ?>">
                            <div class="input-group-addon">h/semana</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 text-left">
                            <button type="button" onclick="location.href = 'form/dados_gerais.php'" class="btn btn-lg btn-warning">Voltar</button>
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