<?php
class Padronizacao {
  public static function padronizarMaiMin($v){
    return ucwords(strtolower($v));
  }

  public static function padronizarMai($v){
    return ucwords($v);
  }

  public static function antiXSS($v){
    return htmlspecialchars($v);
  }
}
