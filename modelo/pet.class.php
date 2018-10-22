<?php
class Pet {

  private $idPet;
  private $nome;
  private $raca;
  private $idade;
  private $peso;
  private $dono;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a, $v){$this->$a = $v;}

  public function __toString(){
    return nl2br("Nome: $this->nome
                  Raca: $this->raca
                  Idade: $this->idade
                  Peso: $this->peso
                  Dono: $this->dono");

  }
}
