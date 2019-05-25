<?php
require_once 'php/controle_acesso/conexao.php';
require_once 'phpmailer/PHPMailerAutoload.php';
require_once 'php/funs.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = md5(implode($_POST));

    if (!isset($_SESSION['last_request']) || (isset($_SESSION['last_request']) && $_SESSION['last_request'] != $request)) {
        $_SESSION['last_request'] = $request;

        $p = &$_POST;
        
        $nome = value($p, 'tNome');
        $email = value($p, 'eEmail');
        $assunto = value($p, 'tAssunto');
        $mensagem = nl2br(value($p, 'taMensagem'));
    
        // Inicia a classe PHPMailer
        $mail = new PHPMailer();
        // Define os dados do servidor e tipo de conexão
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->IsSMTP(); // Define que a mensagem será SMTP
    
        try
        {
            require_once 'php/controller_adm/config_mail.php';

            // Define o remetente
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->setFrom("gpeg.uesc@gmail.com", "GPEG");
            // Define os dados técnicos da Mensagem
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
            $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
            $mail->Subject = "[CONTATO] $assunto"; // Assunto da mensagem
                
            // Define os destinatário(s)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->AddAddress("gpeg.uesc@gmail.com", "Contato GPEG");
            //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
            //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
            // Define a mensagem (Texto e Assunto)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

            $mail->Body = "<strong>Nome:</strong> $nome<br><strong>Email:</strong> $email<br><strong>Assunto:</strong> $assunto<br><strong>Mensagem:</strong> $mensagem";
            $mail->AltBody = "Nome: $nome Email: $email Assunto: $assunto Mensagem: $mensagem";
            // Define os anexos (opcional)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
            // Envia o e-mail
            $enviado = $mail->Send();
            // Limpa os destinatários e os anexos
            $mail->ClearAllRecipients();
            //$mail->ClearAttachments();
            // Exibe uma mensagem de resultado
            
            if (!$enviado)
                echo "<script>window.alert('Erro, favor contatar o suporte!');window.location.href='../index.php';</script>";
            else
                echo "<script>window.alert('Mensagem enviada com sucesso!');window.location.href='../index.php';</script>";
    
        } catch (Exception $e) {
            echo "<script>window.alert('Erro, favor contatar o suporte!');window.location.href='../index.php';</script>";
        }
    }
}

?>