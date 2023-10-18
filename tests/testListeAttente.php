<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
var_dump(ListeAttente());
