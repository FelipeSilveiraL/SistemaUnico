<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailErroProcedure extends Controller
{
    public function enviarEmail()
    {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->Username = 'desenvolvimento@servopa.com.br';
            $mail->Password = 'Cpdtec05';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->CharSet = 'UTF-8';

            // Remetente e destinatário
            $mail->setFrom('desenvolvimento@gruposervopa.com.br', 'Desenvolvimento');
            $mail->addAddress('desenvolvimento@gruposervopa.com.br', 'Desenvolvimento');
            $mail->addAddress('celina@servopa.com.br', 'Celina Hara');
            $mail->addAddress('smart@gruposervopa.com.br', 'Smartshare Desenvolvimento');


            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Vistorias VEX - ERRO';
            $mail->Body = 'Prezados, existem algumas vistorias pendentes na VEX que requerem análise.';
            $mail->send();

            //EXCLUINDO AS TABELAS
            tabelaVetor(2);
            tabelaSelbetti(2);
            tabelaRelatorio(2);

            return 'E-mail enviado com sucesso!';
        } catch (Exception $e) {

            return 'Erro ao enviar e-mail: ' . $mail->ErrorInfo;
        }
    }
}
