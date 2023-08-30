<?php
include_once '../controllers/ControlCliente.php';
$cc = new ControlCliente();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Koop - Criar conta</title>
  <link rel="shortcut icon" href="icon-koop.png" type="image/png">
  <link id="sleek-css" rel="stylesheet" href="../css/sleek.min.css" />
  <link type="text/css" rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/alert.css">
</head>
<body style="background-color: rgb(154,0,1)">
  <div class="container-fluid d-flex flex-column justify-content-between vh-100">
    <div class="row justify-content-center mt-5">
      <?php
      if (isset($_POST['btn'])) : // Cadastrar cliente
        $cc->criarConta(
          $_POST['nome'],
          $_POST['sobrenome'],
          $_POST['datanasc'],
          $_POST['sexo'],
          $_POST['tel1'],
          $_POST['bairro'],
          $_POST['rua'],
          $_POST['email'],
          $_POST['pass']
        );
      endif;
      ?>
      <div class="col-sm-12 col-xs-12 col-md-9">
        <div class="card">
          <div class="card-header bg-primary">
            <div class="app-brand">
              <a href="../views/index.php">
                <img src="../img/logo/koop-logo.png" alt="" style="text-align:center">
              </a>
            </div>
          </div>
          <div class="card-body p-5">
            <h4 class="text-dark mb-5">Criar conta</h4>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
              <div class="row">
                <div class="form-group col-md-6 mb-4">
                  <input type="text" name="nome" class="form-control input-lg" maxlength="20" aria-describedby="nameHelp" placeholder="*Nome" title="Nome, 20 caracters no máximo " required>
                </div>
                <div class="form-group col-md-6 mb-4">
                  <input type="text" name="sobrenome" class="form-control input-lg" maxlength="15" placeholder="*Sobrenome" title="Sobrenome, 15 caracters no máximo " required>
                </div>
                <div class="form-group col-md-6 ">
                  <span class="brand-name" id="">Data de Nascimento</span>
                  <input type="date" name="datanasc" class="form-control input-lg" placeholder="Data de nascimento" title="Data de Nascimento" required>
                </div>
                <div class="form-group col-md-2 ">
                  <span class="brand-name">Sexo</span>
                  <div class="input-radio">
                    <input type="radio" name="sexo" value="Masculino" id="masculino" title="Masculino" checked>
                    <label for="masculino">
                      <span></span>
                      Masculino
                    </label>
                  </div>
                  <div class="input-radio">
                    <input type="radio" name="sexo" value="Femenino" id="Femenino" title="Femenino">
                    <label for="Femenino">
                      <span></span>
                      Femenino
                    </label>
                  </div>
                </div>
                <div class="form-group col-md-6 ">
                  <input type="tel" name="tel1" class="form-control input-lg" maxlength="9" placeholder="*Número de telefone " title="Número de telefone" required>
                </div>
                <div class="form-group col-md-6 ">
                </div>
                <div class="form-group col-md-6 ">
                  <input type="text" name="bairro" class="form-control input-lg" maxlength="15" placeholder="*Bairro" title="Bairro, no máximo 15 caracteres" required>
                </div>
                <div class="form-group col-md-6 ">
                  <input type="text" name="rua" class="form-control input-lg" maxlength="20" placeholder="*Rua" title="Rua, no máximo 20 caracteres" required>
                </div>
                <div class="form-group col-md-6 ">
                  <input type="email" name="email" class="form-control input-lg" maxlength="40" placeholder="*E-mail" title="Email, no máximo 40 caracteres" required>
                </div>
                <div class="form-group col-md-6 ">
                  <input type="text" name="pass" class="form-control input-lg" maxlength="10" placeholder="*Palavra-Passe" title="Palavra - passe, no máximo 10 caracteres" required>
                </div>
                <div class="col-md-6">
                  <div class="d-inline-block mr-3">
                    <div class="input-checkbox">
                      <input type="checkbox" name="termo" id="terms" value="true" onclick=" termoCodicao()" title="Termos e condições">
                      <label for="terms">
                        <span></span>
                        LI E ACEITO <a href="index.php?sessao=termoscondicoes" style="color:#D10024">termos & condições</a>
                      </label>
                    </div>
                    <div class="input-checkbox">
                      <span class="">*Campos obrigatórios</span>
                    </div>
                    <div class="input-checkbox">
                      <span class="">Se não aceita os nossos <a href="index.php?sessao=termoscondicoes" style="color:#D10024">termos & condições</a> não pode ter uma conta Koop.</span>
                    </div>
                  </div>
                  <button type="submit" name="btn" id="btn-criar-conta" class="btn btn-lg btn-primary btn-block mb-4 mt-4">Criar conta</button>
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
  <script>
    // Aceitar os termos e condições
    var btn = document.getElementById('btn-criar-conta');
    btn.disabled = true;

    var termos = document.getElementById('terms');
    termos.checked = false;

    function termoCodicao() {
      var termos = document.getElementById('terms');
      var btn = document.getElementById('btn-criar-conta');
      if (termos.checked) {
        btn.disabled = false;
      } else {
        btn.disabled = true;
      }
    }
  </script>
</body>

</html>