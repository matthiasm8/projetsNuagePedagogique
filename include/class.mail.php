<?php

use phpmailer\phpmailer\phpmailer;
use phpmailer\phpmailer\Exception;
require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';

class Mail{
    
/* Fonction qui envoie un token de vérification de 6 caractères à l'adresse mail indiquée. */

function envoiMail($token,$lelogin){
    $mail = new PHPMailer(true);

    $mail->isSMTP();$mail->Host = 'smtp.gmail.com';$mail->SMTPAuth=true;
    $mail->Username='balavoinedev@gmail.com';$mail->Password='kdsgrpkdmszivmfr';
    $mail->SMTPSecure='ssl';$mail->Port=465;$mail->IsHTML(true);$mail->CharSet = "utf-8";

    $mail->setFrom('balavoinedev@gmail.com');

    $mail->addAddress($_POST['login']);
    // $mail->addAddress('matthias.muyl@gmail.com');
 
    $mail->Subject = "Confirmez votre inscription à GSB Extranet";

    // $mail->Body = file_get_contents("templatemail.php");

    $mail->Body ='<a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php?uc=validation&action=demandeValidation&mail='.$lelogin.'" target="_blank">ici</a>'.$token.'';

    $mail->send();
    // header('Location: index.php?uc=validation&action=demandeValidation&mail='.$lelogin.'');

}



function envoiMailValidateur($prenom,$nom){
    
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='balavoinedev@gmail.com';
    $mail->Password='kdsgrpkdmszivmfr';
    $mail->SMTPSecure='ssl';
    $mail->Port=465;
    $mail->IsHTML(true);
    $mail->CharSet = "utf-8";



    $mail->setFrom('balavoinedev@gmail.com');
    
    /*$mail->addAddress($_POST['login']);*/
    $mail->addAddress('matthias.muyl@gmail.com');
 
    $mail->Subject = "Nouveau compte à valider sur GSB.";
    
    // $mail->Body = file_get_contents("templatemail.php");

    $mail->Body ='Un nouveau médecin souhaite s\'inscrire sur GSB : <br>'.$prenom.' '.$nom.'<br><a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php" target="_blank">Valider le médecin</a>';

    $mail->send();
}

}