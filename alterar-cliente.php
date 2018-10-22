<?php
session_start();
ob_start();
include_once 'util/helper.class.php';

if (isset($_GET['id'])) {
  include_once "dao/clientedao.class.php";
  include_once "modelo/cliente.class.php";

  $clienteDAO = new ClienteDAO();
  $array = $clienteDAO->filtrar($_GET['id'], "codigo");


  $cliente = $array[0];

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alteração de Cliente</title>
  <meta charset="UTF-8">
	<meta name="description" content="Riverside Drive - Dê o tratamento que seu pet merece!">
	<meta name="autor" content="Desenvolvido por Müller Gonçalves">
	<meta name="keywords" content="Petshop, Banho, Tosa, Animais">
	<link rel="icon" href="images/icon.png">
  <link rel="stylesheet" type="text/css" href="style/estilo.css">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
    <div id="geral">
      <a href="index.html"><header class="topo"> </header></a>
				<nav class="cssmenu"> 
					<ul>
						<li>
						<div class="dropdown">
							<a class="dropbtn">Pet</a>
							<div class="dropdown-content">
								<a href="cadastro-pet.php">Cadastrar Pet</a>
								<a href="consulta-pets.php">Consultar os Pets</a>
							</div>
						</div>	
						</li>
						<li>
						<li>
						<div class="dropdown">
							<a class="dropbtn">Cliente</a>
							<div class="dropdown-content">
								<a href="cadastro-cliente.php">Cadastrar Cliente</a>
								<a href="consulta-clientes.php">Consultar os Clientes</a>
							</div>
						</div>	
						</li>
						<li>
						<div class="dropdown">
							<a class="dropbtn">Funcionário</a>
							<div class="dropdown-content">
									<a href="cadastro-funcionario.php">Cadastrar Funcionário</a>
									<a href="consulta-funcionarios.php">Consultar os Funcionários</a>
							</div>
						</div>	
						</li>
					</ul>	
				</nav>
        <?php
        echo isset($_SESSION['msg']) ? Helper::alert($_SESSION['msg']) : "";
        unset($_SESSION['msg']);
        ?>
        <section class="conteudo">
          <form name="cadcliente" method="post" action="">
            <div class="form-group">
              <input type="text" name="txtnome" placeholder="Nome" class="form-control" value="<?php if(isset($cliente)){ echo $cliente->nome; }?>">
            </div>
            <div class="form-group">
              <input type="text" name="txtendereco" placeholder="Endereco" class="form-control" value="<?php if(isset($cliente)){ echo $cliente->endereco; }?>">
            </div>
            <div class="form-group">
              <input type="text" name="txtcomplemento" placeholder="Complemento" class="form-control" value="<?php if(isset($cliente)){ echo $cliente->complemento; }?>">
            </div>
            <div class="form-group">
              <input type="number" name="txtnumero" placeholder="Numero" class="form-control" value="<?php if(isset($cliente)){ echo $cliente->numero; }?>">
            </div>
            <div class="form-group">
              <input type="number" name="txtcpf" placeholder="Cpf" class="form-control" value="<?php if(isset($cliente)){ echo $cliente->cpf; }?>">
            </div>
            <div class="form-group">
              <input type="submit" name="Alterar" value="Alterar" class="btn btn-primary">
              <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
            </div>
          </form>
        </section>
        <?php
        if(isset($_POST['Alterar'])){
          include_once 'modelo/cliente.class.php';
          include_once 'dao/clientedao.class.php';
          include 'util/padronizacao.class.php';

          $cliente = new Cliente();
          $cliente->idCliente = $_GET['id'];
          $cliente->nome = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtnome']));
          $cliente->endereco = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtendereco']));
          $cliente->complemento = Padronizacao::antiXSS(Padronizacao::padronizarMai($_POST['txtcomplemento']));
          $cliente->numero = $_POST['txtnumero'];
          $cliente->cpf = Padronizacao::antiXSS($_POST['txtcpf']);

          $clienteDAO = new ClienteDAO();
          $clienteDAO->alterarCliente($cliente);

          $_SESSION['msg'] = "Cliente alterado com sucesso!";
          header("location:consulta-clientes.php");
          ob_end_flush();
          }
        ?>
      <footer class="rodape">
        <address> petshop@gmail.com.br </address>
      </footer>
      </div>
  </body>
</html>
