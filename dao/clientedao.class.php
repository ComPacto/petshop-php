<?php
require 'conexaobanco.class.php';
 class ClienteDAO {

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarCliente($cliente){
     try{
       $stat = $this->conexao->prepare("insert into cliente
                                    (idcliente,nome,endereco,complemento,numero,cpf)
                                    values(null,?,?,?,?,?)");
       $stat->bindValue(1, $cliente->nome);
       $stat->bindValue(2, $cliente->endereco);
       $stat->bindValue(3, $cliente->complemento);
       $stat->bindValue(4, $cliente->numero);
       $stat->bindValue(5, $cliente->cpf);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao cadastrar! ".$e;
     }
   }

   public function buscarClientes(){
     try{
       $stat = $this->conexao->query("select * from cliente");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Cliente');
       return $array;
     }catch(PDOException $e){
       echo "Erro ao buscar clientes! ".$e;
     }
   }

   public function filtrar($pesquisa, $filtro){
     try {
       $query = "";
       switch ($filtro) {
         case 'todos': $query = "";
         break;
         case 'codigo': $query = "where idcliente =".$pesquisa;
         break;
         case 'nome': $query = "where nome like '%".$pesquisa."%'";
         break;
         case 'endereco': $query = "where endereco like '%".$pesquisa."%'";
         break;
         case 'complemento': $query = "where complemento like '%".$pesquisa."%'";
         break;
         case 'numero': $query = "where numero =".$pesquisa;
         break;
         case 'cpf': $query = "where cpf =".$pesquisa;
         break;
       }

       $stat = $this->conexao->query("select * from cliente {$query}");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Cliente');
       return $array;
     } catch (PDOException $e) {
       echo "Erro ao filtrar os clientes! ".$e;
     }
   }

   public function alterarCliente($cliente){
     try {
       $stat = $this->conexao->prepare("update cliente set nome=?, endereco=?, complemento=?, numero=?, cpf=? where idcliente=?");

       $stat->bindValue(1, $cliente->nome);
       $stat->bindValue(2, $cliente->endereco);
       $stat->bindValue(3, $cliente->complemento);
       $stat->bindValue(4, $cliente->numero);
       $stat->bindValue(5, $cliente->cpf);
       $stat->bindValue(6, $cliente->idCliente);

       $stat->execute();
     } catch (PDOException $e) {
       echo "Erro ao alterar o cliente! ".$e;
     }

   }

   public function deletarCliente($id){
     try{
       $stat = $this->conexao->prepare("delete from cliente where idcliente = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao excluir o cliente! ".$e;
     }
   }
 }
