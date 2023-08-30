  <?php
  include_once '../controllers/ControlProduto.php';
  include_once '../controllers/ControlUsuario.php';

  $cp = new ControlProduto();
  $cu = new ControlUsuario();

  if (isset($_POST['btn-finalizar'])) :
    if (empty($_SESSION['carrinho']) && !isset($_COOKIE['carrinho'])) : // Se carrinho de compra estiver vazio
      echo '<script>alert("🛒 carrinho de compra vazio ⛔");</script>';
      echo '<h5 class="text-center bg-danger">Adiciona produto(s) no carrinho de compra para finalizar compra</h5>';
    elseif (isset($_SESSION['idcliente'])) : // Se cliente estiver logado
      if (isset($_POST['quantenco'])) : // Se o produto tem quantidade
        $qt = array(); // Array que guarda a quantidade de produto no carrinho
        $i = 0;
        foreach ($_POST['quantenco'] as $quant) :
          $qt[$i++] = "&qtpd[]=" . base64_encode(base64_encode($quant)); // Adicionar quantidades no array e com as suas chaves
        endforeach; ?>
        <script>
          window.location.href = "<?php $_SERVER['PHP_SELF']; ?>?sessao=finalizar<?php foreach ($qt as $v) : echo $v; endforeach;?>"; 
        </script>
  <?php else :
        echo '<script> alert("Produto sem quantidade");</script>';
      endif;
    else : // Se cliente não estiver logado
      login("", "");
    endif;
  endif;
  ?>
  <style>
    table#table-carrinho tr:hover {
      background-color: rgb(206, 206, 255)
    }

    table#table-carrinho tr {
      transition: background-color 1s;
    }
  </style>
  <div id="breadcrumb" class="section">
    <!-- BREADCRUMB -->
    <div class="container">
      <!-- container -->
      <div class="row">
        <!-- row -->
        <div class="col-md-12">
          <ul class="breadcrumb-tree">
            <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home">Casa</a></li>
            <li class="active">Carrinho de compra</li>
          </ul>
        </div>
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /BREADCRUMB -->
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=vercarrinho" method="post">
    <section class="cart_area">
      <!--================Cart Area =================-->
      <div class="container">
        <div class="cart_inner">
          <div class="table-responsive">
            <table class="table" id="table-carrinho">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th>
                    <h3>Produto</h3>
                  </th>
                  <th>Preço</th>
                  <th>Quantidade</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($_SESSION['carrinho']) && !isset($_COOKIE['carrinho'])) :
                  echo '<h4 class="text-center">Nenhum produto adicionado ao carrinho 🛒😥</h4>';
                else :
                  if (empty($_SESSION['carrinho'])) : // Se sessão estiver vazia adicionar na sessão o id que esta guardado no cookie carrinho
                    $_SESSION['carrinho'] = unserialize(stripcslashes($_COOKIE['carrinho']));
                  endif;
                  $id_tag_total = -1; // Id da tag que vai receber o preco total de um único produto
                  $preco_total_input = -1; // Id do proceço total de cada produto em um input 
                  $preco_total_produtos = 0;
                  foreach ($_SESSION['carrinho'] as $id) :
                    foreach ($cp->produtoCarrinho($id) as $dados) :
                      $id_tag_total++; // Id da tag que vai receber o preco total de um único produto
                      $preco_total_input++; // Id da tag que vai receber o preco total de um único produto
                      ?>
                      <tr>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                          <td>
                            <div class="input-checkbox">
                              <input type="checkbox" id="<?php echo $dados['idproduto'] . 'check'; ?>" name="checkbox" value="<?php echo base64_encode(base64_encode($dados['idproduto'])); ?>">
                              <label for="<?php echo $dados['idproduto'] . 'check'; ?>">
                                <span></span>
                              </label>
                            </div>
                            <!--Checkbox para eliminar-->
                          </td>
                          <td>
                            <div>
                              <input type="number" name="idprodel" value="<?php echo $dados['idproduto']; ?>" hidden>
                              <button type="submit" name="btn-eliminar" class="btn btn-danger btn-xs" style="background-color:#D10024;"><i class="fa fa-minus-circle" style=""></i> Eliminar</button>
                            </div>
                          </td>
                        </form>
                        <td>
                          <div class="product-widget">
                            <!-- product widget -->
                            <div class="product-img">
                              <img src="../img/<?php echo strtolower($dados['nomecategoria']) .  "/" .  $dados['foto']; ?>" alt="">
                            </div>
                            <div class="product-body">
                              <p class="product-category"><?php echo $dados['nomecategoria']; ?></p>
                              <h3 class="product-name" style="color:#D10024;"><?php echo $dados['nome']; ?></h3>
                            </div>
                          </div>
                          <!-- /product widget -->
                        </td>
                        <td class="preco-total">
                          <h5 class="preco-total"><?php echo number_format($dados['preco_ac'], 0, ',', '.'); ?> Akz</h5>
                        </td>
                        <td>
                          <div class="quickview_body">
                            <div class="quantity">
                              <!--Button - -->
                              <span class="qty-minus" onclick="
                            var quant = document.getElementById('<?php echo $dados['idproduto'] ?>');
                            var preco = document.getElementById('<?php echo $dados['nome'] ?>');
                            var total = document.getElementById(<?php echo $id_tag_total; ?>);
                            var total_input = document.getElementsByName('total_input')[<?php echo $preco_total_input; ?>]; // Preço Total no input

                            var preco_ac = Number(preco.value);
                            var quantidade = Number(quant.value) - 1; // Diminuir a quantidade

                            if(quantidade == 0){
                              total.innerHTML = preco_ac.toLocaleString('pt-BR');
                            }else{
                              if(quantidade > 0){
                                var mult = (quantidade * preco_ac); // Multiplicar a quantidade com o preço
                                total.innerHTML = mult.toLocaleString('pt-BR'); // Pegar o preço total de um produto na tag
                                total_input.value = mult; // Preço Total no input
                              }
                              // Somatório de todos preços totais
                            var pt = 0;
                            for(var i = 0; i < <?php echo count($_SESSION['carrinho']); ?>; i++){
                              var preco_total = document.getElementsByName('total_input')[i]; // Pegar os preços
                              pt += Number(preco_total.value); // Somatório
                            }
                              if(quantidade > 0){
                                preco_total_produtos.innerHTML = Number(pt).toLocaleString('pt-BR'); // Receber o somatório de todos os preços totais
                              }
                            }

                            if( !isNaN( quantidade ) && quantidade > 0 )
                              quant.value--;
                            return false;">
                                <i class="fa fa-minus" aria-hidden="true"></i></span>
                              <!--Quantidade do produto do js-->
                              <input type="number" class="qty-text" id="<?php echo $dados['idproduto']; ?>" step="1" min="1" name="quantenco[]" value="1" readonly>
                              <!--Primeiro Preço do produto-->
                              <input type="number" id="<?php echo $dados['nome'] ?>" value="<?php echo $dados['preco_ac']; ?>" hidden>
                              <!--Preço total de cada produto-->
                              <input type="number" name="total_input" value="<?php echo $dados['preco_ac']; ?>" hidden>
                              <!--Button + -->
                              <span class="qty-plus" onclick="
                            var quant = document.getElementById('<?php echo $dados['idproduto'] ?>');
                            var preco = document.getElementById('<?php echo $dados['nome'] ?>');
                            var total = document.getElementById(<?php echo $id_tag_total; ?>); // Preco total a vista do usuario
                            var total_input = document.getElementsByName('total_input')[<?php echo $preco_total_input; ?>]; // Preço Total no input
                            var preco_total_produtos = document.getElementById('preco_total_produtos'); // Preco de total de todos os produtos
                            
                            var preco_ac = Number(preco.value); //
                            var quantidade = Number(quant.value) + 1; // Aumentar a quantidade
                            
                            var mult = (quantidade * preco_ac); // Multiplicar a quantidade com o preço
                            total.innerHTML = mult.toLocaleString('pt-BR'); // Adicionar o Preço total a vista do usuario
                            
                            total_input.value = mult; // Adicionar Preço Total no input
                            // Somatório de todos preços totais
                            var pt = 0;
                            for(var i = 0; i < <?php echo count($_SESSION['carrinho']); ?>; i++){
                              var preco_total = document.getElementsByName('total_input')[i]; // Pegar os preços
                              pt += Number(preco_total.value); // Somatório
                            }
                            preco_total_produtos.innerHTML = Number(pt).toLocaleString('pt-BR'); // Receber o somatório de todos os preços totais

                            if( !isNaN( quantidade ))
                            quant.value++;
                            return false;
                           ">
                                <i class="fa fa-plus" aria-hidden="true"></i></span>
                            </div>
                          </div>
                        </td>
                        <td class="preco">
                          <h5 class="preco" id="<?php echo $id_tag_total; ?>"><?php echo number_format($dados['preco_ac'], 0, ',', '.'); ?></h5>
                        </td>
                      </tr>
                <?php
                      $preco_total_produtos += $dados['preco_ac']; // Somatório dos preços
                    endforeach;
                  endforeach;
                endif;
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <i class="fa fa-long-arrow-up"></i>
            <div class="btn-group">
              <div class="input-checkbox">
                <input type="checkbox" onclick="marcarTodos()" id="marcar-todos">
                <label for="marcar-todos">
                  <span></span>
                  <strong>Marcar todos</strong>
                </label>
              </div>
            </div>
            <div class="btn-group">
              <div class="col-md-2 col-sm-2 col-xs-2" style="margin-bottom:10px">
                <!-- <a class="btn btn-primary btn-sm" href="<?php $_SERVER['PHP_SELF']; ?>?sessao=home"> <i class="fa fa-home"></i> Casa</a> -->
                <a class="btn btn-success btn-sm" href="javascript:history.go(-1)"> <i class="fa fa-long-arrow-left"></i> Voltar onde estava</a>
              </div>
            </div>
            <div class="btn-group">
              <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px">
                <input type="button" onclick="eliminar()" class="btn btn-danger btn-sm" style="background-color:black;" value="⛔Eliminar">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Cart Area =================-->
    <br>
    <br>
    <div class="container">
      <div class="row">
        <!-- Order Details -->
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 order-details">
          <div class="order-summary">
            <div class="order-col">
              <div>Entrega <i class="fa fa-truck" style="color:#D10024;"></i></div>
              <div><strong>GRÁTIS</strong></div>
            </div>
            <div class="order-col">
              <div><strong>TOTAL</strong></div>
              <div><strong class="order-total" id="preco_total_produtos"><?php if (isset($preco_total_produtos)) : echo number_format($preco_total_produtos, 0, ',', '.');
                                                                          endif; ?></strong></div>
            </div>
          </div>
          <div class="col-md-offset-2 col-sm-offset-2 col-xs-offset-2">
            <button type="submit" name="btn-finalizar" class="primary-btn btn-primary order-submit"><i class="fa fa-check-square-o"></i> Finalizar compra</button>
          </div>
        </div>
        <!-- /Order Details -->
      </div>
      <!-- /row -->
    </div>
  </form>

  <script>
    function eliminar() { // Eliminar produto marcado que está no carrinho
      let ids = [];
      for (var i = 0; i < <?php echo count($_SESSION['carrinho']); ?>; i++) { // contar o número de produto no carrinho
        var check = document.getElementsByName('checkbox'); // Pegar o checkbox marcado
        if (check[i].checked) { // cada checkbox marcado executa
          var id = document.getElementsByName('checkbox')[i]; // Pegar o id do checkbox marcado
          ids += "&icquant[]=" + id.value; // Incrementar ids de produtos marcados no vector idp
        }
      }
      if (ids == "") {
        alert('Nenhum produto marcado');
      } else {
        window.location.href = "<?php $_SERVER['PHP_SELF']; ?>?sessao=vercarrinho" + ids; // Enviar o id para url
      }
    }

    function marcarTodos() { // Marcar todos os produtos
      var marcar = document.getElementById('marcar-todos'); // Pegar o checkbox de marcar todos
      for (var i = 0; i < <?php echo count($_SESSION['carrinho']); ?>; i++) { // contar o número de produto no carrinho
        var check = document.getElementsByName('checkbox'); // Pegar o name de todos checkbox
        if (marcar.checked) { // Se for marcado
          check[i].checked = true; // Marcar todos checkbox
        } else {
          check[i].checked = false; // Desmarcar todos os checkbox
        }
      }

    }
  </script>