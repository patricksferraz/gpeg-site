<?php
require_once '../php/controle_acesso/conexao.php';
require_once '../php/controle_acesso/logar.php';
require_once '../php/funs.php';
require_once '../php/controle_acesso/session.php';
require_once '../php/controller_write/cgeral.php';

date_default_timezone_set("America/Bahia");
$p = &$_POST;

if ($_SESSION && isset($_SESSION['agent']) && isset($_SESSION['acesso']) && $_SESSION['acesso'])
    header("location: gerenciador_pesquisa.php");

if ($p)
{
    $con = con_db_gpge();
    $login = strtolower(value($p, 'tLogin'));
    $senha = value($p, 'pSenha');

    $data = logar($con, $login, $senha);

    if (isset($data['flag']) && !$data['flag'])
    {
        require_once '../php/controle_acesso/logout.php';
        session_set_cookie_params(0);
        session_name(md5('blocker_gpge' . $_SERVER['REMOTE_ADDR'] . 'blocker_gpge' . $_SERVER['HTTP_USER_AGENT'] . 'blocker_gpge'));
        session_start();
        $_SESSION['acesso'] = true;
        $_SESSION['id_usuario'] = $data['id_usuario'];
        $_SESSION['apelido'] = $data['apelido'];
        $_SESSION['nome'] = $data['nome'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);

        // Registra o acessodo usuário 
        $sql = "INSERT INTO lac_log_acesso (lac_data_acesso, lac_id_usuario) VALUES (?, ?)";
        action($con, $sql, [[date('Y-m-d H:i:s'), $data['id_usuario']]]);

        header("location: gerenciador_pesquisa.php");
    }
    else
        $acesso = false;
    
    $con = null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once '../include/head.php'; ?>
    <title>GPEG - Login</title>
</head>
<body style="background-color: #ff9100">

    <div class="container">

        <div id="telaAcesso" class='container-fluid'>
            <div class="panel panel-default col-md-8 col-md-offset-2">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="index.php" class="logo">GPGE</a>
                        </div>
                        <h2 class="col-md-12 text-center">Olá! Para continuar efetue o acesso.</h2>
                    </div>

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" accept-charset="utf-8">

                        <div class="row">
                            <?php
                            if (isset($acesso) && !$acesso):
                            ?>
                            <div class="alert alert-danger col-md-12" role="alert">
                                Usuário ou senha incorretos.
                            </div>
                            <?php
                            endif;
                            ?>
                            <div class="form-group col-md-12">
                                <label for="tLogin" class="control-label">Apelido/Email:</label>
                                <input name="tLogin" type="text" class="form-control" value="<?php if(isset($login)) echo $login ?>" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="pSenha" class="control-label">Senha:</label>
                                <input name="pSenha" type="password" class="form-control" value="<?php if(isset($senha)) echo $senha ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <a href="#">Esqueceu a senha?</a><!--recuperar_senha.php-->
                                <div class="pull-right">
                                    <!--<button type="button" class="btn btn-warning"><span class="fa fa-user-plus" aria-hidden="true"></span> Cadastre-se</button>-->
                                    <button type="submit" class="btn btn-warning"><span class="fa fa-sign-in" aria-hidden="true"></span> Entrar</button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>


        </div>
    </div>

</body>
</html>