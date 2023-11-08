<?php

use phpmailer\phpmailer\phpmailer;
use phpmailer\phpmailer\Exception;
require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';

class Mail{
    
/* Fonction qui envoie un token de vérification de 6 caractères à l'adresse mail reçue en paramètre. */

function envoiMail($token,$lelogin){
    $mail = new PHPMailer(true);

    $mail->isSMTP();$mail->Host = 'smtp.gmail.com';$mail->SMTPAuth=true;
    $mail->Username='balavoinedev@gmail.com';$mail->Password='kdsgrpkdmszivmfr';
    $mail->SMTPSecure='ssl';$mail->Port=465;$mail->IsHTML(true);$mail->CharSet = "utf-8";

    $mail->setFrom('balavoinedev@gmail.com');

    $mail->addAddress($lelogin);
 
    $mail->Subject = "Token de validation GSB Extranet";

    $mail->Body = $token;

    $mail->send();

}

/* Fonction qui envoie un mail au validateur lui indiquant qu'un compte dont l'identité est reçue en paramètre doit être validé. */

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
    
    $mail->addAddress('matthias.muyl@gmail.com');
 
    $mail->Subject = "Nouveau compte à valider sur GSB.";

    $mail->Body ='Un nouveau médecin souhaite s\'inscrire sur GSB : <br>'.$prenom.' '.$nom.'<br><a href="https://s5-4573.nuage-peda.fr/projet/gsbextranetB3/index.php" target="_blank">Valider le médecin</a>';

    $mail->send();
}


}