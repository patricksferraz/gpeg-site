<?php
require_once '../controle_acesso/conexao.php';
require_once '../../phpmailer/PHPMailerAutoload.php';
require_once '../funs.php';
require_once '../controller_write/cgeral.php';

$p = &$_POST;
$con = con_db_gpge();

if ($con) {
    
    $dataInicio = value($p, 'dPeriodoInicial');
    $dataFim = value($p, 'dPeriodoFinal');

    // Inicia a classe PHPMailer
    $mail = new PHPMailer();
    // Define os dados do servidor e tipo de conexão
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsSMTP(); // Define que a mensagem será SMTP

    try {
        
        require_once 'config_mail.php';

        // Define o remetente
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->setFrom("gpeg.uesc@gmail.com", "GPEG");
        // Define os dados técnicos da Mensagem
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
        $mail->Subject = "Pesquisa de Gestão Escolar"; // Assunto da mensagem

        $sql = "SELECT max(peq_id_pesquisa) FROM peq_pesquisa";
        $proxPesquisa = proxId($con, $sql);
        $sql = "INSERT INTO peq_pesquisa (peq_id_pesquisa, peq_data_inicio_pesquisa, peq_data_final_pesquisa) VALUES (?, ?, ?)";
        action($con, $sql, array(array($proxPesquisa, $dataInicio, $dataFim)));

        $sql = "SELECT des_id_escola, des_email, des_nome_escola FROM des_dados_escola";
        $stmt = $con->query($sql);
        $row = $stmt->fetchAll();

        $sql = "INSERT INTO pge_pesquisa_gestao (pge_hash_pesquisa, pge_concluido, pge_data_ultima_alteracao, pge_id_pesquisa, pge_id_escola) VALUES (?, ?, ?, ?, ?)";

        foreach ($row as $r) {
            // Define os destinatário(s)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $idEscola = $r['des_id_escola'];
            $email = $r['des_email'];
            $escola = $r['des_nome_escola'];
            $mail->AddAddress($email, $escola);
            //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
            //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
            // Define a mensagem (Texto e Assunto)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $hash = md5($email . $escola . $dataInicio . $dataFim);
            action($con, $sql, array(array($hash, 0, null, $proxPesquisa, $idEscola)));
            
            $mail->Body = "Prezado Diretor (a)<br><br>
            O Grupo de Pesquisa em Educação e Gestão (<a target='_blank' href='http://gpeg.com.br'>GPEG</a>), da Universidade Estadual de Santa Cruz (UESC), encaminha abaixo um link para um formulário, solicitamos a Vossa Senhoria o seu preenchimento. Ele não tomará mais do que 10 minutos do seu tempo. Na oportunidade ,informamos da importância do seu preenchimento para melhoria da qualidade das políticas públicas na Bahia.<br><br>
            <a target='_blank' href='http://gpeg.com.br/form/apresentacao.php?hash=$hash'>Clique aqui</a> para encaminhá-lo ao formulário ou acesse a página <a target='_blank' href='http://gpeg.com.br'>GPEG</a> e insira o código <strong>$hash</strong> no campo de busca.<br>Período para preenchimento da pesquisa:<br>". date('d/m/Y', strtotime($dataInicio)) ." - ". date('d/m/Y', strtotime($dataFim)) ."<br><br>
            Certos de contar com a sua colaboração e apoio, atenciosamente,<br><br>
            Josefa Sônia P. Da Fonseca<br>
            Coordenadora do GPEG";
            $mail->AltBody = "Prezado Diretor (a) 
            O Grupo de Pesquisa em Educação e Gestão (GPEG), da Universidade Estadual de Santa Cruz (UESC), encaminha abaixo um link para um formulário, solicitamos a Vossa Senhoria o seu preenchimento. Ele não tomará mais do que 10 minutos do seu tempo. Na oportunidade ,informamos da importância do seu preenchimento para melhoria da qualidade das políticas públicas na Bahia. 
            Cole o endereço http://gpeg.com.br/form/apresentacao.php?hash=$hash no seu navegador para encaminhá-lo ao formulário ou acesse a página http://gpeg.com.br e insira o código $hash no campo de busca. Período para preenchimento da pesquisa: ". date('d/m/Y', strtotime($dataInicio)) ." - ". date('d/m/Y', strtotime($dataFim)) ." 
            Certos de contar com a sua colaboração e apoio, atenciosamente, 
            Josefa Sônia P. Da Fonseca 
            Coordenadora do GPEG";
            // Define os anexos (opcional)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
            // Envia o e-mail
            $enviado = $mail->Send();
            // Limpa os destinatários e os anexos
            $mail->ClearAllRecipients();
            //$mail->ClearAttachments();
            // Exibe uma mensagem de resultado
            if (!$enviado) {
                $erro[] = $email;
            }
        }

        $stmt = $row = $con = null;
        echo "Pesquisa gerada com sucesso!";
        header("location: ../../adm/gerenciador_pesquisa.php");

    } catch (Exception $e) {

        $con = null;
        echo "Erro, favor contatar o suporte!";

    }
} else {
    echo "Erro, favor contatar o suporte!";
}

?>