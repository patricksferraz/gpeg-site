<?php
require_once 'php/controle_acesso/conexao.php';
require_once 'php/controller_write/cgeral.php';
require_once 'php/funs.php';

$r = &$_REQUEST;
$id_event = value($r, 'event');

date_default_timezone_set("America/Bahia");
$con = con_db_gpge();

$data_e = null;
$end_e = null;
$pre_e = null;
$escolas = null;
$alert = null;
$alert_geral = null;

if ($con) {
    $sql_select = "SELECT eve_data_fim_inscricao FROM eve_evento WHERE eve_id_evento = ?";
    if (!($eve = existe($con, $sql_select, [$id_event])))
        $alert_geral = "<div class='alert alert-danger text-center' role='alert'>
        O evento não foi localizado na nossa base de dados. Lamentamos o transtorno.
        </div>";
    elseif (date('Y-m-d') > $eve[1])
        $alert_geral = "<div class='alert alert-danger text-center' role='alert'>
        Infelizmente o prazo para inscrição já foi encerrado. Fique atento aos próximos prazos.
        </div>";
    else {
        session_start();
        
        if( $_SERVER['REQUEST_METHOD']=='POST' ) {
            $request = md5( implode( $_POST ) );
            
            if( isset( $_SESSION['last_request'] ) && $_SESSION['last_request']== $request ) {
                // POG para tratar cadastro duplicado
                $l = "Location: ".$_SERVER['PHP_SELF']."?event=".$id_event;
                header($l);
            }
            else {
                $_SESSION['last_request']  = $request;
    
                $nome               = value($r, 'tNome');
                $sobrenome          = value($r , 'tSobrenome');
                $nome_cracha        = value($r , 'tNomeCracha');
                $email              = value($r , 'eEmail');
                $telefone           = value($r , 'tTelefone');
                $id_escola          = value($r , 'sEscola');
                $formacao           = value($r , 'tFormacao');
                $respondeu_pesquisa = value($r , 'rRespondeuPesquisa');
                $curso_preferencia  = value($r , 'taCursoPreferencia');
    
                $sql_select = "SELECT pes_id_pessoa FROM pes_pessoa WHERE pes_email = ?";
                if ($pes = existe($con, $sql_select, [$email])) $id_pessoa = $pes[1];
                else {
                    // Verificando proxima chave de pessoa
                    $sql_proxid = "SELECT MAX(pes_id_pessoa) FROM pes_pessoa";
                    $id_pessoa = proxId($con, $sql_proxid);
    
                    // Inserindo telefone
                    $sql_insert = "INSERT INTO pes_pessoa (pes_id_pessoa, pes_nome, pes_sobrenome, pes_formacao, pes_email)
                    VALUES (?, ?, ?, ?, ?)";
                    action($con, $sql_insert, [[$id_pessoa, $nome, $sobrenome, $formacao, $email]]);
    
                    // Inserindo novo telefone pessoa
                    $sql_insert = "INSERT INTO tep_telefone_pessoa (tep_id_pessoa, tep_telefone) VALUES (?, ?)";
                    action($con, $sql_insert, [[$id_pessoa, $telefone]]);
                }
    
                $sql_select = "SELECT * FROM ine_inscrito_evento WHERE ine_id_pessoa = ?";
                if (existe($con, $sql_select, [$id_pessoa])) 
                    $alert = "<div class='alert alert-danger alert-dismissible text-center' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    Olá, este e-mail já foi utilizado para inscrição no evento, caso desconheça a inscrição, entre em contato com <b>gpeg.uesc@gmail.com</b>.
                    </div>";
                else {
    
                    // Verificando proxima chave de inscrito
                    $sql_proxid = "SELECT MAX(ine_id_inscrito_evento) FROM ine_inscrito_evento";
                    $id_inscrito = proxId($con, $sql_proxid);
        
                    // Inserindo nova inscrição
                    $sql_insert = "INSERT INTO ine_inscrito_evento
                    (ine_id_inscrito_evento, ine_id_pessoa, ine_id_evento, ine_apelido, ine_data_inscricao)
                    VALUES (?, ?, ?, ?, ?)";
                    action($con, $sql_insert, [[$id_inscrito, $id_pessoa, $id_event, $nome_cracha, date('Y-m-d H:i:s')]]);
        
                    // Inserindo nova inscrição da pesquisa
                    $sql_insert = "INSERT INTO iep_inscrito_evento_pesquisa
                    (iep_id_inscrito_evento, iep_id_escola_pessoa, iep_respondeu_pesquisa, iep_temas_curso_preferencia)
                    VALUES (?, ?, ?, ?)";
                    action($con, $sql_insert, [[$id_inscrito, $id_escola, $respondeu_pesquisa, $curso_preferencia]]);
                    
                    $alert = "<div class='alert alert-success alert-dismissible text-center' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    Inscrição realizada com sucesso!
                    </div>";

                    unset($r);
                }
            }
        }
        
        // eve_id_evento, eve_titulo, eve_data_inicio, eve_data_fim, eve_hora_inicio, eve_hora_fim, eve_email, eve_telefone, eve_descricao
        $sql = "SELECT * FROM eve_evento WHERE eve_id_evento = ?";
        $data_e = actionSelect($con, $sql, [$id_event])[0];
        
        //end_id_cep , end_rua_av, end_bairro, end_cidade, end_estado
        //ede_id_endereco_evento, ede_id_evento, ede_id_cep, ede_numero, ede_pais, ede_complemento
        $sql = 'SELECT * FROM ede_endereco_evento INNER JOIN end_endereco ON end_id_cep = ede_id_cep WHERE ede_id_evento = ?';
        $end_e = actionSelect($con, $sql, [$id_event])[0];
        
        //pre_id_programacao_evento, pre_id_evento, pre_titulo, pre_descricao, pre_data, pre_hora
        $sql = 'SELECT * FROM pre_pogramacao_evento WHERE pre_id_evento = ?';
        $pre_e = actionSelect($con, $sql, [$id_event]);
        
        //des_id_escola, des_nome_escola, des_municipio, des_email
        $sql = 'SELECT * FROM des_dados_escola ORDER BY des_nome_escola ASC';
        $escolas = actionSelect($con, $sql);
    }

    // POG para captura do nome da escola
    $sql_select = "SELECT des_nome_escola FROM des_dados_escola WHERE des_id_escola = ?";
    $des = existe($con, $sql_select, [value($r , 'sEscola')]);
    //
    
    $con = null;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'include/head.php';?>
    <title>GPEG</title>
</head>
<body>

    <header>
        <?php require_once 'include/header.php';?>
    </header>

    <main>
        <?php if ($alert_geral): ?>

        <section class="container margin-top">
            <?php echo $alert_geral; ?>
        </section>
        
        <?php else: ?>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <blockquote>
                            <h4 class="modal-title">Programação</h4>
                        </blockquote>
                    </div>
                    <div class="modal-body">
                        <p>
                            <?php
                            $date = null;
                            foreach ($pre_e as $p) {
                                if ($date != $p['pre_data']) {
                                    $date = $p['pre_data'];
                                    echo "<b><span class='glyphicon glyphicon-calendar color-gpeg' aria-hidden='true'></span> " . date_format(date_create($date), 'd/m/Y') . "</b><br>";
                                }
                                echo "<small><b>" . $p['pre_hora'] . "</b> - "
                                . $p['pre_titulo'] . "<br>"
                                . (($p['pre_descricao'] != null) ? ("<i>" . $p['pre_descricao'] . "</i></small><br>"): "</small>");
                            }
                            ?>
                        </p>
                        
                        <hr>
                        <h5><b>Mais informações:</b></h5>
                        <?php if (value($data_e, 'eve_telefone')): ?>
                        <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                        <?php echo $data_e['eve_telefone'] . "<br>";
                        endif; ?>

                        <?php if(value($data_e, 'eve_email')):?>
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        <?php echo $data_e['eve_email'];
                        endif;?>
                    </div>
                </div>
            </div>
        </div>

        <section class="container-fluid margin-top">
            <div class="row">

                <div class="col-md-6 margin-bottom">
                    <div class="jumbotron">
                        <blockquote>
                            <h3><?php echo value($data_e, 'eve_titulo') ?></h3>
                        </blockquote>
                        <p class="text-justify"><?php echo value($data_e, 'eve_descricao') ?></p>
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>

                        <?php
                        $dti = value($data_e, 'eve_data_inicio');
                        $dtf = value($data_e, 'eve_data_fim');

                        if (($dti == $dtf) && $dti != null) echo date_format(date_create($dti), 'd/m/Y');
                        else echo (($dti) ? date_format(date_create($dti), 'd/m/Y') : "N/A") . " - " . (($dtf) ? date_format(date_create($dtf), 'd/m/Y') : "N/A");
                        ?>

                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>

                        <?php
                        $hri = value($data_e, 'eve_hora_inicio');
                        $hrf = value($data_e, 'eve_hora_fim');

                        echo (($hri) ? $hri : "N/A") . " - " . (($hrf) ? $hrf : "N/A");
                        ?><br>

                        <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>
                        
                        <?php
                        $complemento = value($end_e, 'ede_complemento');
                        
                        echo value($end_e, 'end_rua_av') . ", "
                        . value($end_e, 'ede_numero') . ", "
                        . value($end_e, 'end_bairro') . ", CEP: "
                        . value($end_e, 'end_id_cep') . ", "
                        . value($end_e, 'end_cidade') . "-" . value($end_e, 'end_estado') . "<br>"
                        . (($complemento) ? "<small><i>" . $complemento . "</i></small>" : "");
                        ?>
                        
                        <!-- Button trigger modal -->
                        <p><a class="btn btn-warning btn-sm" href="#" role="button" data-toggle="modal" data-target="#myModal">Programação</a></p>
                    </div>
                    
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d123431.0346824891!2d-39.33519504216851!3d-14.812915194150415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x739a818ecf672d9%3A0xa2fa69b5171b4521!2sUniversidade+Estadual+de+Santa+Cruz!5e0!3m2!1spt-BR!2sbr!4v1537415724177" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>

                <div id="fichaInscricaos" class="col-md-6 margin-bottom">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <blockquote>
                            <h4>Ficha de inscrição</h4>
                        </blockquote>

                        <?php echo $alert; ?>
                        
                        <div class="form-group col-md-12">
                            <h6 class="text-danger">* Campos obrigatórios</h6>
                        </div>
                        <input id="event" name="event" type="hidden" class="form-control" value="<?php echo $id_event; ?>" readonly>
                        <div class="form-group col-md-5">
                            <label for="tNome">Nome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tNome" name="tNome" maxlength="50" value="<?php echo value($r, 'tNome') ?>" required>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="tSobrenome">Sobrenome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tSobrenome" name="tSobrenome" maxlength="255" value="<?php echo value($r, 'tSobrenome') ?>" required>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="tNomeCracha">Nome para o crachá <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tNomeCracha" name="tNomeCracha" maxlength="100" value="<?php echo value($r, 'tNomeCracha') ?>" required>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="eEmail">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="eEmail" name="eEmail" maxlength="255" value="<?php echo value($r, 'eEmail') ?>" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="tTelefone">Telefone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tTelefone" name="tTelefone" maxlength="50" value="<?php echo value($r, 'tTelefone') ?>" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="sEscola">Escola em que trabalha</label>
                            <select class="form-control" id="sEscola" name="sEscola">
                                <option value="<?php echo value($r, 'sEscola') ?>"><?php echo $des[1] ?></option>
                                <?php
                                foreach ($escolas as $e)
                                    echo "<option value='" . $e['des_id_escola'] . "'>" . $e['des_nome_escola'] . "</option>";
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="tFormacao">Sua formação</label>
                            <input type="text" class="form-control" id="tFormacao" name="tFormacao" maxlength="255" value="<?php echo value($r, 'tFormacao') ?>">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Você já respondeu a pesquisa Gestão da escola e os resultados do IDEB: Qual a relação? <span class="text-danger">*</span></label><br>
                            <label class="radio-inline">
                                <input type="radio" name="rRespondeuPesquisa" value="1" <?php if (($rp = value($r, 'rRespondeuPesquisa')) == 1) echo "checked" ?> required> Sim
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="rRespondeuPesquisa" value="0" <?php if ((($rp = value($r, 'rRespondeuPesquisa')) != null) && $rp == 0) echo "checked" ?>> Não
                            </label>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="taCursoPreferencia">Quais temas ou cursos você gostaria de participar?</label>
                            <textarea class="form-control" rows="3" id="taCursoPreferencia" name="taCursoPreferencia" maxlength="1000"><?php echo value($r, 'taCursoPreferencia') ?></textarea>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-warning">Realizar Inscrição</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>

        <?php endif; ?>
    </main>

    <?php require_once 'include/footer.php';?>

</body>
</html>
