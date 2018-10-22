<?php
class Funcionario {

  private $idFuncionario;
  private $nome;
  private $endereco;
  private $funcao;
  private $cpf;
  private $salario;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a, $v){$this->$a = $v;}

  public function __toString(){
    return nl2br("Nome do funcionário: $this->nome
                  Endereço: $this->endereco
                  Função: $this->função
                  CPF: $this->cpf
                  Salário: $this->salario");

  }
}
