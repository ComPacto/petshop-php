<?php
session_start();
ob_start();

include_once 'dao/petdao.class.php';
include_once 'modelo/pet.class.php';
include_once 'util/helper.class.php';

$petDAO = new PetDAO();
$array = $petDAO->buscarPets();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Consulta de Pets</title>
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
            <h2>Consulta de Pets!</h2>
            <?php
            if(isset($_SESSION['msg'])){
              Helper::alert($_SESSION['msg']);
              unset($_SESSION['msg']);
            }

            if(count($array) == 0){
                echo "<h2>Não há pets no banco!</h2>";
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
                    <option value="nome">Nome do Pet</option>
                    <option value="raca">Raça</option>
                    <option value="idade">Idade</option>
                    <option value="peso">Peso</option>
                    <option value="dono">Dono</option>
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
          $petDAO = new PetDAO();
          $array = $petDAO->filtrar($pesquisa,$filtro);

          if(count($array) == 0){
            echo "<h3>Sua pesquisa não retornou nenhum pet!</h3>";
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
                <th>Nome</th>
                <th>Raça</th>
                <th>Idade</th>
                <th>Peso</th>
                <th>Dono</th>
                <th>Excluir</th>
                <th>Alterar</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Raça</th>
                <th>Idade</th>
                <th>Peso</th>
                <th>Dono</th>
                <th>Excluir</th>
                <th>Alterar</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              foreach($array as $p){
                echo "<tr>";
                  echo "<td>$p->idPet</td>";
                  echo "<td>$p->nome</td>";
                  echo "<td>$p->raca</td>";
                  echo "<td>$p->idade</td>";
                  echo "<td>$p->peso</td>";
                  echo "<td>$p->dono</td>";
                  echo "<td><a href='consulta-pets.php?id=$p->idPet' class='btn btn-danger'>Excluir</a></td>";
                  echo "<td><a href='alterar-pet.php?id=$p->idPet' class='btn btn-warning'>Alterar</a></td>";
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
      $petDAO->deletarPet($_GET['id']);
      $_SESSION['msg'] = "Pet excluído com sucesso!";
      header("location:consulta-pets.php");
    }
    ?>
  </div>
  </body>
</html>
