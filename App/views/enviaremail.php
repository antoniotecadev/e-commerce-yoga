<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Koop</title>
    </head>
    <body>
        <?php
		$nome = $_POST['nome'];
		$telefone = $_POST['tel'];
		$email = $_POST['email'];
		$assunto = $_POST['assunto'];
		$mensagem = $_POST['mensagem'];
        require 'vendor/autoload.php';
        $from = new SendGrid\Email(null, $email);
        $subject = $assunto;
        $to = new SendGrid\Email(null, "koop@koopangola.com");
        $content = new SendGrid\Content("text/html", "Olá Koop Angola, <br><br>Nova mensagem de contato<br><br>Nome: $nome<br>Email: $email<br>Mensagem: $mensagem");
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        //Necessário inserir a chave
        $apiKey = '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';
        $sg = new \SendGrid($apiKey);
        $response = $sg->client->mail()->send()->post($mail);
        if ($response->statusCode() == 202): ?>
            <script>
			alert('Mensagem enviada com sucesso');<?php
			header('refresh:0;url=' . $_SERVER['PHP_SELF'] . '?sessao=faleconnosco');?>
			</script>;<?php
        endif;
        ?>
    </body>
</html>
