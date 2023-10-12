<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
var_dump($pdo->valideConnexion('6c2a39','matthias.muyl@gmail.com'));

// var_dump($pdo->valideUser('derbal18dz@gmail.com','Cazorla2327!'));