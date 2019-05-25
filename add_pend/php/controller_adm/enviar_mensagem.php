<?php
require_once '../controle_acesso/conexao.php';
require_once '../controller_write/cgeral.php';
require_once '../../phpmailer/PHPMailerAutoload.php';
require_once '../funs.php';
require_once '../controller_write/cgeral.php';

date_default_timezone_set("America/Bahia");
$p = &$_POST;
$con = con_db_gpge();

if ($con) {
    
    $id_pesquisa   = value($p, 'pesq');
    $id_usuario    = value($p, 'usr');
    $tDestinatario = value($p, 'tdest');
    $assunto       = value($p, 'ass');
    $mensagem      = nl2br(value($p, 'msg'));
    $lembrete      = value($p, 'lbt');
    $eDestinatario = value($p, 'edest');

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

        $mail->Subject = $assunto; // Assunto da mensagem

        $sql = "SELECT peq_data_final_pesquisa FROM peq_pesquisa WHERE peq_id_pesquisa = ?";
        $row = actionSelect($con, $sql, [$id_pesquisa])[0];
        $dataFim = $row[0];

        // Envio para TODOS
        if ($tDestinatario == 0) {
            $sql = "SELECT pge_id_pesquisa_gestao, pge_hash_pesquisa, des_email, des_nome_escola FROM pge_pesquisa_gestao
            INNER JOIN des_dados_escola ON des_id_escola = pge_id_escola
            WHERE pge_id_pesquisa = ?";
            $row = actionSelect($con, $sql, [$id_pesquisa]);
        }
        // Envio para Submetidos
        if ($tDestinatario == 1) {
            $sql = "SELECT pge_id_pesquisa_gestao, pge_hash_pesquisa, des_email, des_nome_escola FROM pge_pesquisa_gestao
            INNER JOIN des_dados_escola ON des_id_escola = pge_id_escola
            WHERE pge_concluido = ? AND pge_id_pesquisa = ?";
            $row = actionSelect($con, $sql, [1, $id_pesquisa]);
        }
        // Envio para Em edição
        if ($tDestinatario == 2) {
            $sql = "SELECT pge_id_pesquisa_gestao, pge_hash_pesquisa, des_email, des_nome_escola FROM pge_pesquisa_gestao
            INNER JOIN des_dados_escola ON des_id_escola = pge_id_escola
            WHERE pge_data_ultima_alteracao IS NOT NULL AND pge_concluido = ? AND pge_id_pesquisa = ?";
            $row = actionSelect($con, $sql, [0, $id_pesquisa]);
        }
        // Envio para Pendentes
        if ($tDestinatario == 3) {
            $sql = "SELECT pge_id_pesquisa_gestao, pge_hash_pesquisa, des_email, des_nome_escola FROM pge_pesquisa_gestao
            INNER JOIN des_dados_escola ON des_id_escola = pge_id_escola
            WHERE pge_data_ultima_alteracao IS NULL AND pge_concluido = ? AND pge_id_pesquisa = ?";
            $row = actionSelect($con, $sql, [0, $id_pesquisa]);
        }
        // Envio privativo
        if ($tDestinatario == 4) {
            $sql = "SELECT pge_id_pesquisa_gestao, pge_hash_pesquisa, des_email, des_nome_escola FROM pge_pesquisa_gestao
            INNER JOIN des_dados_escola ON des_id_escola = pge_id_escola
            WHERE des_email = ? AND pge_id_pesquisa = ?";
            $row = actionSelect($con, $sql, [$eDestinatario, $id_pesquisa]);
        }

        $sql = "SELECT max(men_id_mensagem) FROM men_mensagem";
        $id_mensagem = proxId($con, $sql);
        $sql = "INSERT INTO men_mensagem (men_id_mensagem, men_assunto, men_mensagem) VALUES (?,?,?)";
        action($con, $sql, [[$id_mensagem, $assunto, $mensagem]]);

        $date_send = date('Y-m-d H:i:s');
        $data = null;
        foreach ($row as $r) {
            // Define os destinatário(s)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $id_pesquisa_gestao = $r['pge_id_pesquisa_gestao'];
            $hash = $r['pge_hash_pesquisa'];
            $email = $r['des_email'];
            $escola = $r['des_nome_escola'];
            $mail->AddAddress($email, $escola);
            // Define a mensagem (Texto e Assunto)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            
            $mail->Body = $mensagem;
            if ($lembrete == 1) $mail->Body .= "<br><br>
                ---
                <h5>Seu código de acesso à pesquisa é: <strong><a target='_blank' href='http://gpeg.com.br/form/apresentacao.php?hash=$hash'>$hash</a></strong> [Prazo final: <strong>". date('d/m/Y', strtotime($dataFim)) ."</strong>]</h5>";
            $mail->AltBody = $mensagem;
            if ($lembrete == 1) $mail->AltBody .= "<br><br>
                ---
                <h5>Seu código de acesso à pesquisa é: <strong>$hash</strong> [Prazo final: <strong>". date('d/m/Y', strtotime($dataFim)) ."</strong>]</h5>";
            // Define os anexos (opcional)
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
            // Envia o e-mail
            $enviado = $mail->Send();
            // Limpa os destinatários e os anexos
            $mail->ClearAllRecipients();
            //$mail->ClearAttachments();
            // Exibe uma mensagem de resultado
            if (!$enviado) $enviado = 0;
            else $enviado = 1;
            
            $data[] = [$date_send, $lembrete, $enviado, $id_mensagem, $id_pesquisa_gestao, $id_usuario];
        }
        $sql = "INSERT INTO lmp_log_mensagem_pesquisa
            (lmp_data_envio, lmp_lembrete_pesquisa, lmp_enviado, lmp_id_mensagem, lmp_id_pesquisa_gestao, lmp_id_usuario_enviou)
            VALUES (?,?,?,?,?,?)";
        action($con, $sql, $data);

        $stmt = $row = $con = null;
        echo json_encode(['enviado' => true]);

    } catch (Exception $e) {

        $con = null;
        echo json_encode(['enviado' => false]);

    }
} else {
    echo json_encode(['enviado' => false]);
}

?>