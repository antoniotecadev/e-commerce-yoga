<?php
if (isset($_POST['btn'])):
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
	alert('Mensagem enviada com sucesso');
    document.location.href = history.go(-1);
	</script>;<?php
endif;
endif;
?>
<style>
    ul#contacto li{
        display: inline-block;
        font-size:medium;
        padding: 10px;
        background-color: #D10024;
        border-radius: 10px;
        margin-left: 10px;
    }
    ul#contacto{
        text-align: center;
    }
</style>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Fale connosco</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home">Casa</a></li>
                    <li class="active">Fale connosco</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <div class="col-md-7">
                <!-- Billing Details -->
                <div class="billing-details">
                    <div class="section-title">
                    <form method="POST" action="faleconnosco.php">
                        <h3 class="title">Envie a sua mensagem</h3>
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="nome" value="<?php if (isset($_SESSION['nomecli'])) : echo $_SESSION['nomecli'] . ' ' . $_SESSION['sobrenome'];
                                                                            endif; ?>" placeholder="Nome completo">
                    </div>
                    <div class="form-group">
                        <input class="input" type="tel" name="tel" value="<?php if (isset($_SESSION['telefone1'])) : echo $_SESSION['telefone1'];
                                                                            endif; ?>" placeholder="Número de telefone">
                    </div>
                    <div class="form-group">
                        <input class="input" type="email" name="email" value="<?php if (isset($_SESSION['email'])) : echo $_SESSION['email'];
                                                                                endif; ?>" placeholder="Endereço de Email">
                    </div><br>
                    <div class="form-group">
                        <input class="input" type="text" onfocus="this.value='';" name="assunto" placeholder="Assunto" required>
                    </div>
                </div>
                <!-- /Billing Details -->
                <!-- Order notes -->
                <div class="order-notes">
                    <textarea class="input" onfocus="this.value='';" name="mensagem" placeholder="Escreve a mensagem..." required></textarea>
                </div>
                <!-- /Order notes -->
                <?php
                if (isset($_SESSION['idcliente'])) : // Se cliente estiver logado
                    $estado = '';
                    else :
                        $estado = 'disabled';
                endif;
                ?>
                <input type="submit" name="btn" desab <?php echo $estado; ?> class="primary-btn order-submit" value="Enviar mensagem"><br><br>
            </form>
            </div>
            <br><br><br><br>
            <!-- Order Details -->
            <div class="col-md-5 order-details">
                <div class="section-title text-center">
                    <h4 class="title">Contacto</h4>
                </div>
                <div class="order-summary">
                    <div class="order-col">
                        <div><strong><i class="fa fa-mobile-phone" style="font-size:xx-large; color: #D10024;"></i></strong></div>
                        <div>
                            <span>+244 932 561 531</span>
                        </div>
                    </div>
                    <div class="order-col">
                        <div><strong><i class="fa fa-envelope-o" style="font-size:x-large; color: #D10024;"></i></strong></div>
                        <div>
                            <span>koop@koopangola.com</span>
                        </div>
                    </div><br>
                    <div class="order-col">
                        <ul class="newsletter-follow" id="contacto">
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-whatsapp"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Order Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->