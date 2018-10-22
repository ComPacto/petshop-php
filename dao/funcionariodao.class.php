<?php
require 'conexaobanco.class.php';
 class FuncionarioDAO {

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarFuncionario($funcionario){
     try{
       $stat = $this->conexao->prepare("insert into funcionario
                                    (idfuncionario,nome,endereco,funcao,cpf,salario)
                                    values(null,?,?,?,?,?)");
       $stat->bindValue(1, $funcionario->nome);
       $stat->bindValue(2, $funcionario->endereco);
       $stat->bindValue(3, $funcionario->funcao);
       $stat->bindValue(4, $funcionario->cpf);
       $stat->bindValue(5, $funcionario->salario);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao cadastrar! ".$e;
     }
   }

   public function buscarFuncionarios(){
     try{
       $stat = $this->conexao->query("select * from funcionario");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
       return $array;
     }catch(PDOException $e){
       echo "Erro ao buscar funcionário! ".$e;
     }
   }

   public function filtrar($pesquisa, $filtro){
     try {
       $query = "";
       switch ($filtro) {
         case 'todos': $query = "";
         break;
         case 'codigo': $query = "where idfuncionario =".$pesquisa;
         break;
         case 'nome': $query = "where nome like '%".$pesquisa."%'";
         break;
         case 'endereco': $query = "where endereco like '%".$pesquisa."%'";
         break;
         case 'funcao': $query = "where funcao like '%".$pesquisa."%'";
         break;
         case 'cpf': $query = "where cpf =".$pesquisa;
         break;
         case 'salario': $query = "where salario =".$pesquisa;
         break;
       }

       $stat = $this->conexao->query("select * from funcionario {$query}");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
       return $array;
     } catch (PDOException $e) {
       echo "Erro ao filtrar os funcionário! ".$e;
     }
   }

   public function alterarFuncionario($funcionario){
     try {
       $stat = $this->conexao->prepare("update funcionario set nome=?, endereco=?, funcao=?, cpf=?, salario=? where idfuncionario=?");

       $stat->bindValue(1, $funcionario->nome);
       $stat->bindValue(2, $funcionario->endereco);
       $stat->bindValue(3, $funcionario->funcao);
       $stat->bindValue(4, $funcionario->cpf);
       $stat->bindValue(5, $funcionario->salario);
       $stat->bindValue(6, $funcionario->idFuncionario);

       $stat->execute();
     } catch (PDOException $e) {
       echo "Erro ao alterar o funcionário! ".$e;
     }

   }

   public function deletarFuncionario($id){
     try{
       $stat = $this->conexao->prepare("delete from funcionario where idfuncionario = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao excluir o funcionário! ".$e;
     }
   }
 }
