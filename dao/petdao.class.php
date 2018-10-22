<?php
require 'conexaobanco.class.php';
 class PetDAO {

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarPet($pet){
     try{
       $stat = $this->conexao->prepare("insert into pet
                                    (idpet,nome,raca,idade,peso,dono)
                                    values(null,?,?,?,?,?)");
       $stat->bindValue(1, $pet->nome);
       $stat->bindValue(2, $pet->raca);
       $stat->bindValue(3, $pet->idade);
       $stat->bindValue(4, $pet->peso);
       $stat->bindValue(5, $pet->dono);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao cadastrar! ".$e;
     }
   }

   public function buscarPets(){
     try{
       $stat = $this->conexao->query("select * from pet");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Pet');
       return $array;
     }catch(PDOException $e){
       echo "Erro ao buscar pets! ".$e;
     }
   }

   public function filtrar($pesquisa, $filtro){
     try {
       $query = "";
       switch ($filtro) {
         case 'todos': $query = "";
         break;
         case 'codigo': $query = "where idpet =".$pesquisa;
         break;
         case 'nome': $query = "where nome like '%".$pesquisa."%'";
         break;
         case 'raca': $query = "where raca like '%".$pesquisa."%'";
         break;
         case 'idade': $query = "where idade =".$pesquisa;
         break;
         case 'peso': $query = "where peso =".$pesquisa;
         break;
         case 'dono': $query = "where dono like '%".$pesquisa."%'";
         break;
       }

       $stat = $this->conexao->query("select * from pet {$query}");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Pet');
       return $array;
     } catch (PDOException $e) {
       echo "Erro ao filtrar os pets! ".$e;
     }
   }

   public function alterarPet($pet){
     try {
       $stat = $this->conexao->prepare("update pet set nome=?, raca=?, idade=?, peso=?, dono=? where idpet=?");

       $stat->bindValue(1, $pet->nome);
       $stat->bindValue(2, $pet->raca);
       $stat->bindValue(3, $pet->idade);
       $stat->bindValue(4, $pet->peso);
       $stat->bindValue(5, $pet->dono);
       $stat->bindValue(6, $pet->idPet);

       $stat->execute();
     } catch (PDOException $e) {
       echo "Erro ao alterar o pet! ".$e;
     }

   }

   public function deletarPet($id){
     try{
       $stat = $this->conexao->prepare("delete from pet where idpet = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao excluir o pet! ".$e;
     }
   }
 }
