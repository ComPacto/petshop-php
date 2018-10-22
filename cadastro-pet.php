<?php
session_start();
ob_start();
include_once 'util/helper.class.php';

if (isset($_GET['id'])) {
  include_once "dao/petdao.class.php";
  include_once "modelo/pet.class.php";

  $petDAO = new PetDAO();
  $array = $petDAO->filtrar($_GET['id'], "codigo");


  $pet = $array[0];

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro de Pet</title>
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
        <?php
        if (isset($_SESSION['erros'])) {
          foreach ($erros as $e) {
            echo "<br>".$e;
          }
          unset($_SESSION['erros']);
        }
        ?>
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
            <form name="cadpet" method="post" action="">
              <div class="form-group col-12">
                <input type="text" name="txtnome" placeholder="Nome" class="form-control" value="<?php if(isset($pet)){ echo $pet->nome; }?>">
              </div>
              <div class="form-group col-12">
                <input type="text" name="txtraca" placeholder="Raca" class="form-control" value="<?php if(isset($pet)){ echo $pet->raca; }?>">
              </div>
              <div class="form-group col-12">
                <input type="number" name="txtidade" placeholder="Idade" class="form-control" value="<?php if(isset($pet)){ echo $pet->idade; }?>">
              </div>
              <div class="form-group col-12">
                <input type="number" name="txtpeso" placeholder="Peso" class="form-control" value="<?php if(isset($pet)){ echo $pet->peso; }?>">
              </div>
              <div class="form-group col-12">
                <input type="text" name="txtdono" placeholder="Dono" class="form-control" value="<?php if(isset($pet)){ echo $pet->dono; }?>">
              </div>
              <div class="form-group">
                <input type="submit" name="Cadastrar" value="Cadastrar" class="btn btn-primary">
                <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
              </div>
            </form>
          </section>
          <?php
          if(isset($_POST['Cadastrar'])){
            include_once 'modelo/pet.class.php';
            include_once 'dao/petdao.class.php';
            include 'util/padronizacao.class.php';

            $pet = new Pet();
            $pet->idPet = $_POST['id'];
            $pet->nome = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtnome']));
            $pet->raca = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtraca']));
            $pet->idade = $_POST['txtidade'];
            $pet->peso = $_POST['txtpeso'];
            $pet->dono = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtdono']));

            $petDAO = new PetDAO();
            $petDAO->cadastrarPet($pet);

            $_SESSION['msg'] = "Pet cadastrado com sucesso!";
            header("location:cadastro-pet.php");
            ob_end_flush();
            }
          ?>
          <footer class="rodape">
            <address> petshop@gmail.com.br </address>
          </footer>
        </div> 	
  </body>
</html>
