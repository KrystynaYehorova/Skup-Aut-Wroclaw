<?php

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if (!error_get_last()) {

    $tytul = $_POST['tytul'];
    $marka = filter_var($_POST['marka'], FILTER_SANITIZE_SPECIAL_CHARS);
    $model = filter_var($_POST['model'], FILTER_SANITIZE_SPECIAL_CHARS);
    $rok = filter_var($_POST['rok'], FILTER_SANITIZE_NUMBER_INT);
    $przebieg = filter_var($_POST['przebieg'], FILTER_SANITIZE_NUMBER_INT);
    $cena = filter_var($_POST['cena'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $ubezpieczenie = isset($_POST['ubezpieczenie']) ? 'Tak' : 'Nie';
    $przeglad = isset($_POST['przeglad']) ? 'Tak' : 'Nie';
    $opis = filter_var($_POST['opis'], FILTER_SANITIZE_SPECIAL_CHARS);
    $kontakt = isset($_POST['kontakt']) ? htmlspecialchars($_POST['kontakt']) : '';
    $file = $_FILES['images'];
    

    $title = "Zgloszenie na skup auta";
    $body = "
    <h3> {$tytul}</h3>
    <p><strong>Marka pojazdu:</strong> {$marka}</p>
    <p><strong>Model pojazdu:</strong> {$model}</p>
    <p><strong>Rok produkcji:</strong> {$rok}</p>
    <p><strong>Przebieg pojazdu:</strong> {$przebieg}</p>
    <p><strong>Cena pojazdu:</strong> {$cena}</p>
    <p><strong>Ubezpieczenie:</strong> {$ubezpieczenie}</p>
    <p><strong>Przegląd:</strong> {$przeglad}</p>
    <p><strong>Dodatkowy opis pojazdu:</strong> {$opis}</p>
    <p><strong>Dane kontaktowe:</strong> {$kontakt}</p>
    ";
    
  
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;

    $mail->Debugoutput = function($str, $level) {$GLOBALS['data']['debug'][] = $str;};
    

    $mail->Host       = 'mail.autaskupwroclaw.pl.';
    $mail->Username   = 'skupsamochodow@autaskupwroclaw.pl';
    $mail->Password   = 'Mozumo79!'; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('skupsamochodow@autaskupwroclaw.pl', 'Skup Aut'); 
    
 
    $mail->addAddress('fachhmannauto@gmail.com');  

    if (!empty($file['name'][0])) {
        for ($i = 0; $i < count($file['tmp_name']); $i++) {
            if ($file['error'][$i] === 0) 
                $mail->addAttachment($file['tmp_name'][$i], $file['name'][$i]);
        }
    }
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;    

    if ($mail->send()) {
        $data['result'] = "success";
        $data['info'] = "Wiadomość została pomyślnie wysłana!";
    } else {
        $data['result'] = "error";
        $data['info'] = "Wiadomość nie została wysłana. Wystąpił błąd podczas wysyłania wiadomości";
        $data['desc'] = "Przyczyna: {$mail->ErrorInfo}";
    }
    
} else {
    $data['result'] = "error";
    $data['info'] = "Wystąpił błąd w kodzie";
    $data['desc'] = error_get_last();
}

header('Content-Type: application/json');
echo json_encode($data);
