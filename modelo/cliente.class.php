<?php
class Cliente {

  private $idCliente;
  private $nome;
  private $endereco;
  private $complemento;
  private $numero;
  private $cpf;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a, $v){$this->$a = $v;}

  public function __toString(){
    return nl2br("Nome do cliente: $this->nome
                  Endereço: $this->endereco
                  Complemento: $this->complemento
                  Numero: $this->numero
                  CPF: $this->cpf");

  }
}
