<?php
session_start();
ob_start();
include_once 'util/helper.class.php';

if (isset($_GET['id'])) {
  include_once "dao/funcionariodao.class.php";
  include_once "modelo/funcionario.class.php";

  $funcionarioDAO = new FuncionarioDAO();
  $array = $funcionarioDAO->filtrar($_GET['id'], "codigo");


  $funcionario = $array[0];

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro de Funcionário</title>
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
              <div class="dropdown active">
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
          <form name="cadfuncionario" method="post" action="">
            <div class="form-group">
              <input type="text" name="txtnome" placeholder="Nome do funcionário" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->nome; }?>">
            </div>
            <div class="form-group">
              <input type="text" name="txtendereco" placeholder="Endereco" class="form-control" require="require" value="<?php if(isset($funcionario)){ echo $funcionario->endereco; }?>">
            </div>
            <div class="form-group">
              <input type="text" name="txtfuncao" placeholder="Complemento" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->funcao; }?>">
            </div>
            <div class="form-group">
              <input type="number" name="txtcpf" placeholder="CPF" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->cpf; }?>">
            </div>
            <div class="form-group">
              <input type="number" name="txtsalario" placeholder="Salário" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->salario; }?>">
            </div>
            <div class="form-group">
              <input type="submit" name="Cadastrar" value="Cadastrar" class="btn btn-primary">
              <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
            </div>
          </form>
        </section>
        <?php
        if(isset($_POST['Cadastrar'])){
          include_once 'modelo/funcionario.class.php';
          include_once 'dao/funcionariodao.class.php';
          include 'util/padronizacao.class.php';

          $funcionario = new Funcionario();
          $funcionario->id = $_POST['id'];
          $funcionario->nome = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtnome']));
          $funcionario->endereco = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtendereco']));
          $funcionario->funcao = Padronizacao::antiXSS(Padronizacao::padronizarMai($_POST['txtfuncao']));
          $funcionario->cpf = Padronizacao::antiXSS($_POST['txtcpf']);
          $funcionario->salario = Padronizacao::antiXSS($_POST['txtsalario']);

          $funcionarioDAO = new FuncionarioDAO();
          $funcionarioDAO->cadastrarFuncionario($funcionario);

          $_SESSION['msg'] = "Funcionário cadastrado com sucesso!";
          header("location:cadastro-funcionario.php");
          ob_end_flush();
          }
        ?>
        <footer class="rodape">
          <address> petshop@gmail.com.br </address>
        </footer>
      </div>
  </body>
</html>
