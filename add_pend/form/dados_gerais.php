<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controle_acesso/validar_sessao.php';
require_once '../php/controller_read/cpg1.php';
require_once '../php/funs.php';

$con = con_db_gpge();
$id = $_SESSION['id'];
$data = data_pg1($con, $id);
$con = null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once '../include/head.php'; ?>
    <title>GPEG - Formulário (Dados gerais)</title>
</head>
<body>

    <?php require_once '../include/header.php'; ?>

    <div class="container margin-bottom">

        <div class='container-fluid'>

            <form action="php/controller_write/cpg1.php" method="POST" accept-charset="utf-8">
                <br>
                <div class="row">
                    <h4 class="col-md-6 text-left">Questionário dirigido ao gestor da escola</h4>
                    <h5 class="col-md-6 text-right">Página 1 de 5</h5>
                </div>

                <div class="row">
                    <blockquote>
                        <h4>I - Dados Gerais</h4>
                    </blockquote>
                </div>

                <input type="hidden" id="tid" name="tid" value="<?php echo $id ?>" readonly>
                <input type="hidden" id="flag" name="flag" value="0" readonly>

                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="tNomeEscola">Escola Estadual:</label>
                        <input type="text" class="form-control" id="tNomeEscola" name="tNomeEscola" maxlength="255" value="<?php echo value($data, 'nome_escola'); ?>" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tNomeMunicipio">Município:</label>
                        <input type="text" class="form-control" id="tNomeMunicipio" name="tNomeMunicipio" maxlength="100" value="<?php echo value($data, 'municipio'); ?>" readonly>
                    </div>

                    <div class="col-md-12">
                        <label>Nível de Formação</label>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tLicenciatura">Licenciatura em:</label>
                        <input type="text" class="form-control" id="tLicenciatura" name="tLicenciatura" maxlength="50" value="<?php echo value($data, 0); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tBacharelado">Bacharelado em:</label>
                        <input type="text" class="form-control" id="tBacharelado" name="tBacharelado" maxlength="50" value="<?php echo value($data, 1); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tEspecializacao">Especialização em:</label>
                        <input type="text" class="form-control" id="tEspecializacao" name="tEspecializacao" maxlength="50" value="<?php echo value($data, 2); ?>">
                    </div>

                    <div class="form-group col-md-12" id="rNivelFormacao">
                        <label class="radio-inline">
                            <input type="radio" name="rNivelFormacao" id="rMestrado" value="mestrado" <?php if (isset($data[3])) echo 'checked'; ?>> Mestrado
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rNivelFormacao" id="rMestrando" value="mestrando" <?php if (isset($data[4])) echo 'checked'; ?>> Mestrando
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rNivelFormacao" id="rDoutor" value="doutor" <?php if (isset($data[5])) echo 'checked'; ?>> Doutor
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="rNivelFormacao" id="rDoutorando" value="doutorando" <?php if (isset($data[6])) echo 'checked'; ?>> Doutorando
                        </label>
                    </div>

                    <div class="form-group col-md-6 mestrado">
                        <label for="tAreaMestrado">Área do Mestrado?</label>
                        <input type="text" class="form-control" id="tAreaMestrado" name="tAreaMestrado" maxlength="50" value="<?php echo value($data, 3); ?>">
                    </div>
                    <div class="form-group col-md-6 mestrando">
                        <label for="tAreaMestrado">Área do Mestrado?</label>
                        <input type="text" class="form-control" id="tAreaMestrando" name="tAreaMestrando" maxlength="50" value="<?php echo value($data, 4);?>">
                    </div>
                    <div class="form-group col-md-6 doutor">
                        <label for="tAreaDoutorado">Área do Doutorado?</label>
                        <input type="text" class="form-control" id="tAreaDoutorado" name="tAreaDoutorado" maxlength="50" value="<?php echo value($data, 5); ?>">
                    </div>
                    <div class="form-group col-md-6 doutorando">
                        <label for="tAreaDoutorado">Área do Doutorado?</label>
                        <input type="text" class="form-control" id="tAreaDoutorando" name="tAreaDoutorando" maxlength="50" value="<?php echo value($data, 6); ?>">
                    </div>

                    <div class="form-group col-md-12 text-right">
                        <button type="submit" class="btn btn-lg btn-warning">Próxima</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <?php require_once '../include/footer.php'; ?>
    <script>noSubmitEnter()</script>

</body>
</html>