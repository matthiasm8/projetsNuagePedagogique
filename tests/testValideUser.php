<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
var_dump(valideMedecin(63));

// var_dump($pdo->valideUser('derbal18dz@gmail.com','Cazorla2327!'));