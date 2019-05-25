<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controle_acesso/validar_sessao.php';
require_once '../php/funs.php';

$con = con_db_gpge();
$id = $_SESSION['id'];
$con = null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once '../include/head.php'; ?>
    <title>GPEG - Formulário (Conclusão)</title>
</head>
<body>

    <?php require_once '../include/header.php'; ?>

    <div class="container margin-bottom">

        <div class='container-fluid'>

            <form action="php/controller_write/conclusao.php" method="POST" accept-charset="utf-8">
                <br>
                <div class="row">
                    <h4 class="col-md-6 text-left">Questionário dirigido ao gestor da escola</h4>
                    <h5 class="col-md-6 text-right">Conclusão</h5>
                </div>

                <input type="hidden" id="tid" name="tid" value="<?php echo $id ?>" readonly>

                <div class="row">
                    <blockquote>
                        <h4>Agradecimento e conclusão</h4><br>
                        <p class="text-danger"><strong>Favor clicar em "finalizar pesquisa" para submeter os dados</strong></p>
                    </blockquote>
                </div>

                <div class="row">
                    <hr>
                    <div class="col-md-12">
                        <p class="text-justify">Agradecemos muito sua colaboração e posteriormente entraremos em contato para estreitarmos essa parceria por meio de convite para participação em eventos.<br>
                        Estamos à disposição no e-mail: <strong>gpeg.uesc@gmail.com</strong>
                        </p>
                        <hr><br>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6 text-left">
                            <button type="button" onclick="location.href = 'form/gestao_escola.php'" class="btn btn-lg btn-warning">Voltar</button>
                        </div>
                        <div class="col-xs-6 text-right">
                            <button type="submit" class="btn btn-lg btn-warning">Finalizar Pesquisa</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <?php require_once '../include/footer.php'; ?>

</body>
</html>