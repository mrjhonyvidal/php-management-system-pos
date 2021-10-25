<?php


class Conexion {

  static public function conectar() {

    $link = new PDO("mysql:host=localhost;dbname=cuenca",
                    "root",
                    "guind9090");

    $link->exec("set names utf8");

    return $link;
  }
}