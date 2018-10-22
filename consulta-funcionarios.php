<?php
session_start();
ob_start();

include_once 'dao/funcionariodao.class.php';
include_once 'modelo/funcionario.class.php';
include_once 'util/helper.class.php';

$funcionarioDAO = new FuncionarioDAO();
$array = $funcionarioDAO->buscarFuncionarios();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Consulta de Funcionários</title>
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
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
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
    <section class="conteudoc">
    <h2>Consulta de Funcionários!</h2>
    <?php
    if(isset($_SESSION['msg'])){
      Helper::alert($_SESSION['msg']);
      unset($_SESSION['msg']);
    }

    if(count($array) == 0){
        echo "<h2>Não há funcionários no banco!</h2>";
        return;
    }
    ?>

    <form name="filtrar" method="post" action="">

      <div class="row">
        <div class="form-group col-md-6">
          <input type="text" name="txtfiltro"
                 placeholder="Digite a sua pesquisa" class="form-control">
        </div>

        <div class="form-group col-md-6">
          <select name="selfiltro" class="form-control">
            <option value="todos">Todos</option>
            <option value="codigo">Código</option>
            <option value="nome">Nome do Funcionário</option>
            <option value="endereco">Endereço</option>
            <option value="funcao">Função</option>
            <option value="cpf">CPF</option>
            <option value="salario">Salário</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <input type="submit" name="filtrar" value="Filtrar" class="btn btn-primary btn-block">
      </div>
    </form>
    <?php
    if(isset($_POST['filtrar'])){
      $pesquisa = $_POST['txtfiltro'];
      $filtro = $_POST['selfiltro'];

      if(!empty($pesquisa)){
        $funcionarioDAO = new FuncionarioDAO();
        $array = $funcionarioDAO->filtrar($pesquisa,$filtro);

        if(count($array) == 0){
          echo "<h3>Sua pesquisa não retornou nenhum funcionários!</h3>";
          return;
        }
      }else{
        echo "Digite uma pesquisa!";
      }

    }
    ?>
    </section>
    <section class="conteudoc">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nome do Funcionário</th>
            <th>Endereço</th>
            <th>Função</th>
            <th>CPF</th>
            <th>Salário</th>
            <th>Excluir</th>
            <th>Alterar</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Código</th>
            <th>Nome do Funcionário</th>
            <th>Endereço</th>
            <th>Função</th>
            <th>CPF</th>
            <th>Salário</th>
            <th>Excluir</th>
            <th>Alterar</th>
          </tr>
        </tfoot>
        <tbody>
          <?php
          foreach($array as $f){
            echo "<tr>";
              echo "<td>$f->idFuncionario</td>";
              echo "<td>$f->nome</td>";
              echo "<td>$f->endereco</td>";
              echo "<td>$f->funcao</td>";
              echo "<td>$f->cpf</td>";
              echo "<td>$f->salario</td>";
              echo "<td><a href='consulta-funcionarios.php?id=$f->idFuncionario' class='btn btn-danger'>Excluir</a></td>";
              echo "<td><a href='alterar-funcionario.php?id=$f->idFuncionario' class='btn btn-warning'>Alterar</a></td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>
  <footer class="rodape">
    <address> petshop@gmail.com.br </address>
  </footer>
  </div>
  <?php
  if(isset($_GET['id'])){
    $funcionarioDAO->deletarFuncionario($_GET['id']);
    $_SESSION['msg'] = "Funcionário excluído com sucesso!";
    header("location:consulta-funcionarios.php");
  }
  ?>
</body>
</html>
