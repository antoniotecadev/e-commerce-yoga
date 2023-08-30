<?php
include_once '../Controllers/ControlUsuario.php';
$cu = new ControlUsuario();

$email = "";
if (isset($_GET['eml'])) {
  $email = base64_decode(base64_decode($_GET['eml']));
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Koop - Entrar em sua Conta</title>
  <link rel="shortcut icon" href="icon-koop.png" type="image/png">
  <link rel="stylesheet" href="../css/sleek.min.css" />
  <link rel="stylesheet" href="../css/alert.css">
</head>

<body style="background-color: rgb(154,0,1)">
  <div class="container d-flex flex-column justify-content-between vh-100">
    <div class="row justify-content-center mt-5">
      <div class="col-xl-6 col-xs-12">
        <?php if (isset($_POST['btn'])) : $cu->entrarConta($_POST['email'], $_POST['pass']);
        endif; ?>
        <div class="card">
          <div class="card-header bg-primary">
            <div class="app-brand">
              <a href="../../index.php">
                <img src="../img/logo/koop-logo.png" alt="" style="text-align:center">
              </a>
            </div>
          </div>
          <div class="card-body p-5">
            <h4 class="text-dark mb-2">Iniciar Sessão</h4>
            <p style="color:red;"><?php if (isset($_GET['erro']) && $_GET['erro'] == 'true') : echo 'E-mail / n° de telefone ou palavra-passe errada';
                                  endif; ?></p>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
              <div class="row">
                <div class="form-group col-md-12 mb-2">
                  <input type="text" value="<?php echo $email; ?>" class="form-control input-lg" name="email" id="email" aria-describedby="emailHelp" placeholder="Email ou número de telefone" required autofocus>
                </div>
                <div class="form-group col-md-12 ">
                  <input type="password" class="form-control input-lg" name="pass" id="pass" placeholder="Palavra-Passe" required>
                </div>
                <div class="col-md-12">
                  <div class="d-flex my-2 justify-content-between">
                    <div class="d-inline-block">
                      <label class="control control-checkbox">Manter sessão
                        <input type="checkbox" />
                        <div class="control-indicator"></div>
                      </label>
                    </div>
                    <p><a class="text-blue" style="color:rgb(209, 0, 36)" href="#">Esqueceu sua palavra-passe?</a></p>
                  </div>
                  <button type="submit" name="btn" class="btn btn-lg btn-primary btn-block mb-4">Iniciar Sessão</button>
                  <p>Ainda não possui uma conta Koop ?
                    <a class="text-blue" style="color:rgb(209, 0, 36); font-size:small" href="criarconta.php">Criar Conta</a>
                  </p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright pl-0">
      <p class="text-center">&copy; <script>
          document.write(new Date().getFullYear());
        </script> Copyright Sleek Dashboard Bootstrap Template by
        <a class="text-primary" href="http://www.iamabdus.com/" target="_blank">Abdus</a>.
      </p>
    </div>
  </div>
</body>

</html>