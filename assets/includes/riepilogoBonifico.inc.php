<?php
session_start();
require "../../vendor/autoload.php";
require "./dbconn.inc.php";

use PHPMailer\PHPMailer\PHPMailer;

$iban = "<h6>Beneficiario: <span class='text-dark'>" . $_POST["iban"] . "</span></h6>";
$importo = round((float)$_POST["importo"], 2);
$causale = "<h6>Causale: <span class='text-dark'>" . $_POST["causale"] . "</span></h6>";
$json = array();
$titolo = '<h3 class="text-uppercase">Riepilogo bonifico</h3>';
$input = "<form class='my-3 mx-auto'>
            <div class='row justify-content-center align-items-center'>
                <div class='col-md-6'>
                    <input type='text' name='verifica' id='verifica' class='form-control' placeholder='Inserire codice verifica'>
                </div>
                <div class='col-md-6 text-start'>
                    <button type='button' class='btn button px-3' id='codiceVerificaBonifico'>VERIFICA</button>
                </div>
            </div>";
$security = random_int(10000, 999999);
$conn = openCon();  // apro la connessione

// cerco nel DB lultimo saldo per il CC
$sql = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = '" . $_SESSION["ContoID"] . "' ORDER BY Data DESC LIMIT 1";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) === 1) :
    $result = mysqli_fetch_assoc($query);
    $saldoAttuale = $result["Saldo"];
    $saldoPreventivo = $saldoAttuale - $importo;
    if ($saldoPreventivo > 0) {
        $sql2 = "SELECT * FROM TContiCorrenti WHERE ContoCorrenteID = " . $_SESSION["ContoID"];       
        $query2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_assoc($query2);

        // spedisco una mail col codice di conferma
        $mail = new PHPMailer();
        $mail->isSMTP(); // using SMTP protocol                                     
        $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
        $mail->SMTPAuth = true;  // enable smtp authentication                             
        $mail->Username = 'email';  // sender gmail host              
        $mail->Password = 'password'; // sender gmail host password                          
        $mail->SMTPSecure = 'tls';  // for encrypted connection                           
        $mail->Port = 587;   // port for SMTP 

        $mail->setFrom("email", "Codice sicurezza banca"); // sender's email and name
        $mail->addAddress($row["Email"], $row["NomeTitolare"]);   // receiver's email

        $mail->Subject = "Codice di conferma bonifico";
        $mail->Body = "Codice di conferma: $security";

        if ($mail->send()) {
            // se la email viene spedita inserisco il codice nei tlogin. uso sempre lei perchè non ha senso rifare una tabella uguale per i bonifici
            $sql3 = "INSERT INTO TLogin (ContoCorrenteID, CodiceSicurezza) VALUES (" . $_SESSION["ContoID"] . ", $security)";
            $query3 = mysqli_query($conn, $sql3);
            if ($query3) {
                array_push(
                    $json, 
                    $titolo, 
                    $iban, 
                    "<h6>Importo: <span class='text-dark'>" . round($importo, 2) . " €</span></h6>", 
                    "<h6>Saldo preventivo: <span class='text-dark' id='saldo'>" . round($saldoPreventivo, 2) . " €</span></h6>", 
                    $causale, 
                    $input
                );
            }
        } else {
            array_push($json, "<div class='alert alert-danger'>errore nell'invio del codice</div>");
        }
    } else {
        array_push($json, "<div class='alert alert-danger'>saldo insufficiente</div>");
    }
endif;

echo json_encode($json);
die();
