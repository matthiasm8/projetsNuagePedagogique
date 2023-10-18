<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
var_dump($pdo->checkValide('matthias.muyl@gmail.com','Cazorla2327!'));

var_dump($pdo->checkValide('derbal18dz@gmail.com','Cazorla2327!'));